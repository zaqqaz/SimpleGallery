<?php

namespace AppBundle\Services\Managers\User;

use CoreDomain\DTO\User\ProfileDTO;
use CoreDomain\DTO\User\UserRegisterDTO;
use CoreDomain\Exception\EntityNotFoundException;
use CoreDomain\Exception\LogicException;
use CoreDomain\Exception\ValidationException;
use CoreDomain\Model\User\Password;
use CoreDomain\Model\User\User;
use CoreDomain\Model\User\UserEmployer;
use CoreDomain\Model\User\UserTeacher;
use CoreDomain\Repository\User\UserRepositoryInterface;
use CoreDomain\Repository\User\UserSessionRepositoryInterface;
use CoreDomain\Security\PasswordStrategyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class UserManager
{
    private $em;
    private $userRepository;
    private $userSessionRepository;
    private $passwordEncoder;
    private $validator;

    public function __construct(
        EntityManagerInterface $em,
        UserRepositoryInterface $userRepository,
        UserSessionRepositoryInterface $userSessionRepository,
        PasswordStrategyInterface $passwordEncoder,
        RecursiveValidator $validator
    )
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->userSessionRepository = $userSessionRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    public function register(UserRegisterDTO $userDTO)
    {
        $user = new User($userDTO->getEmail(), new Password($this->passwordEncoder, $userDTO->getPassword()), $userDTO->getRoles());

        if (count($validationErrors = $this->validator->validate($user)) > 0) {
            throw new ValidationException('Bad request', $validationErrors);
        }
        $this->userRepository->addAndSave($user);
        return $user;
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user || !$this->passwordEncoder->isPasswordValid($password, $user->getPassword(), $user->getSalt())) {
            throw new EntityNotFoundException('Неверный логин или пароль');
        }

        $userSession = $user->login();
        $this->userSessionRepository->addAndSave($userSession);

        return $userSession;
    }

    public function logout(User $user)
    {
        $user->logout();
        $this->userSessionRepository->addAndSave($user->getSession());
    }

    public function searchUser($searchStr)
    {
        return $this->userRepository->search($searchStr);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findOneById($id);
    }

    public function getUsersByRole($param)
    {
        $role = $this->getRole($param);
        return $this->userRepository->findAllByRole($role);
    }

    public function updateProfile(User $user, ProfileDTO $profileDTO)
    {
        $this->em->beginTransaction();
        try {
            $user->updateProfile($profileDTO);
            if (count($validationErrors = $this->validator->validate($user)) > 0) {
                throw new ValidationException('Bad request', $validationErrors);
            }
            $this->deleteAttachedPersonsByUser($user, $profileDTO);

            if ($profileDTO->teachers) {
                $this->addTeachersToUser($user, $profileDTO->teachers);
            }
            if ($profileDTO->employers) {
                $this->addEmployersToUser($user, $profileDTO->employers);
            }
            if ($profileDTO->students) {
                $this->addStudentsToTeacher($user, $profileDTO->students);
            }
            if ($profileDTO->employees) {
                $this->addEmployeesToEmployer($user, $profileDTO->employees);
            }
            $this->userRepository->addAndSave($user);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return $user;
    }

    public function deleteUser(User $user)
    {
        $this->userRepository->deleteById($user);
    }

    private function getRole($roleParam)
    {
        switch ($roleParam) {
            case 'teacher':
                return User::ROLE_TEACHER;
                break;
            case 'user':
                return User::ROLE_USER;
                break;
            case 'admin':
                return User::ROLE_ADMIN;
                break;
            case 'corporate':
                return User::ROLE_CORPORATE;
                break;
        }
    }

    private function addTeachersToUser(User $user, $teacherIds)
    {
        //TODO: заменить ROLE_USER на роли онлайн и оффлайн слушателей
        if (!$user->hasRole(User::ROLE_USER)) {
            throw new \Exception("Operation is forbidden for this user role");
        }

        foreach ($teacherIds as $teacherId) {
            $teacher = $this->userRepository->findOneById($teacherId);
            if (!$teacher) {
                throw new \Exception("No teacher entry");
            }
            if (!$teacher->hasRole(User::ROLE_TEACHER)) {
                throw new \Exception("User does not have teacher role");
            }
            $this->userRepository->addTeacherToUser($user, $teacher);
        }
    }

    private function addStudentsToTeacher(User $teacher, $studentIds)
    {
        //TODO: разобраться, какая роль должна быть здесь
        if (!$teacher->hasRole(User::ROLE_TEACHER)) {
            throw new \Exception("Operation is forbidden for this user role");
        }

        foreach ($studentIds as $studentId) {
            $student = $this->userRepository->findOneById($studentId);
            if (!$student) {
                throw new \Exception("No student entry");
            }
            if (!$student->hasRole(User::ROLE_USER)) {
                throw new \Exception("User does not have user role");
            }
            $this->userRepository->addStudentToTeacher($teacher, $student);
        }
    }

    private function addEmployersToUser(User $user, $employerIds)
    {
        //TODO: заменить ROLE_USER на роли онлайн и оффлайн слушателей
        if (!$user->hasRole(User::ROLE_USER)) {
            throw new \Exception("Operation is forbidden for this user role");
        }

        foreach ($employerIds as $employerId) {
            $employer = $this->userRepository->findOneById($employerId);
            if (!$employer) {
                throw new \Exception("No employer entry");
            }
            if (!$employer->hasRole(User::ROLE_CORPORATE)) {
                throw new \Exception("User does not have corporate role");
            }
            $this->userRepository->addEmployerToUser($employer, $user);
        }
    }

    private function addEmployeesToEmployer(User $employer, $employeeIds)
    {
        if (!$employer->hasRole(User::ROLE_CORPORATE)) {
            throw new \Exception("Operation is forbidden for this user role");
        }

        foreach ($employeeIds as $employeeId) {
            $employee = $this->userRepository->findOneById($employeeId);
            if (!$employee) {
                throw new \Exception("No employee entry");
            }
            if (!$employee->hasRole(User::ROLE_USER)) {
                throw new \Exception("User does not have user role");
            }
            $this->userRepository->addEmployeeToEmployer($employer, $employee);
        }
    }

    /**
     * @param User $user
     * @param ProfileDTO $profileDTO
     * Удаляет ненужные связи между учителями и учениками, а также между работодателями и работниками
     */
    private function deleteAttachedPersonsByUser(User $user, ProfileDTO $profileDTO)
    {
        foreach ($user->getTeachers() as $teacher) {
            if (!$profileDTO->teachers || !in_array($teacher->getId(), $profileDTO->teachers)) {
                $this->userRepository->deleteTeacherByUser($user, $teacher);
            } else {
                $profileDTO->teachers = array_diff($profileDTO->teachers, array($teacher->getId()));
            }
        }

        foreach ($user->getEmployers() as $employer) {
            if (!$profileDTO->employers || !in_array($employer->getId(), $profileDTO->employers)) {
                $this->userRepository->deleteEmployerByUser($user, $employer);
            } else {
                $profileDTO->employers = array_diff($profileDTO->employers, array($employer->getId()));
            }
        }

        foreach ($user->getStudents() as $student) {
            if (!$profileDTO->students || !in_array($student->getId(), $profileDTO->students)) {
                $this->userRepository->deleteStudentByTeacher($user, $student);
            } else {
                $profileDTO->students = array_diff($profileDTO->students, array($student->getId()));
            }
        }

        foreach ($user->getEmployees() as $employee) {
            if (!$profileDTO->employees || !in_array($employee->getId(), $profileDTO->employees)) {
                $this->userRepository->deleteEmployeeByEmployer($user, $employee);
            } else {
                $profileDTO->employees = array_diff($profileDTO->employees, array($employee->getId()));
            }
        }
    }
}