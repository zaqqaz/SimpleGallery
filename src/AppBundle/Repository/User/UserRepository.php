<?php

namespace AppBundle\Repository\User;

use CoreDomain\Model\User\UserEmployer;
use CoreDomain\Model\User\UserTeacher;
use Doctrine\ORM\EntityManagerInterface;
use CoreDomain\Repository\User\UserRepositoryInterface;
use CoreDomain\Model\User\User;

class UserRepository implements UserRepositoryInterface
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $email
     * @return User
     */
    public function findOneByEmail($email)
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneById($id)
    {
        $result = $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }

    public function findOneByToken($token, $expirePeriod = 'P7D')
    {
        $validCreatedAt = new \DateTime();
        $validCreatedAt->sub(new \DateInterval($expirePeriod));

        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->innerJoin('u.sessions', 's')
            ->where('s.token = :token')
            ->andWhere('s.createdAt > :date')
            ->setParameter('token', $token)
            ->setParameter('date', $validCreatedAt)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /*public function findUserByConfirmationToken($token)
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.confirmationToken = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }*/

    public function findAllByRole($role = null)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('u')
            ->from(User::class, 'u')
            ->where(
                $qb->expr()->like('u.roles', ':role')
            )
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->addOrderBy('u.middleName', 'ASC')
            ->setParameter('role', '%' . $role . '%')
            ->getQuery()
            ->getResult();
        return $result;
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->em->persist($user);
    }

    public function addAndSave(User $user)
    {
        $this->em->persist($user);
        $this->em->flush($user);
    }

    public function addTeacherToUser(User $user, User $teacher)
    {
        $user->getTeachers()->add($teacher);
        $teacher->getStudents()->add($user);
        $this->em->flush();
    }

    public function addEmployerToUser(User $user, User $employer)
    {
        $user->getEmployers()->add($employer);
        $employer->getEmployees()->add($user);
        $this->em->flush();
    }

    public function addStudentToTeacher(User $teacher, User $student)
    {
        $teacher->getStudents()->add($student);
        $student->getTeachers()->add($teacher);
        $this->em->flush();
    }

    public function addEmployeeToEmployer(User $employer, User $employee)
    {
        $employer->getEmployees()->add($employee);
        $employee->getEmployers()->add($employer);
        $this->em->flush();
    }

    public function deleteById(User $user)
    {
        $this->em->createQueryBuilder()
            ->delete(User::class, 'u')
            ->where('u.id = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }

    public function deleteTeacherByUser(User $user, User $teacher)
    {
        $user->getTeachers()->removeElement($teacher);
        $teacher->getStudents()->removeElement($user);
        $this->em->flush();
    }

    public function deleteEmployerByUser(User $user, User $employer)
    {
        $user->getEmployers()->removeElement($employer);
        $employer->getEmployees()->removeElement($user);
        $this->em->flush();
    }

    public function deleteStudentByTeacher(User $teacher, User $student)
    {
        $teacher->getStudents()->removeElement($student);
        $student->getTeachers()->removeElement($teacher);
        $this->em->flush();
    }

    public function deleteEmployeeByEmployer(User $employer, User $employee)
    {
        $employer->getEmployees()->removeElement($employee);
        $employee->getEmployers()->removeElement($employer);
        $this->em->flush();
    }

    public function search($searchStr)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('u')
            ->from(User::class, 'u')
            ->where(
                $qb->expr()->like(
                    $qb->expr()->lower(
                        $qb->expr()->concat('u.lastName',
                            $qb->expr()->concat($qb->expr()->literal(' '),
                                $qb->expr()->concat('u.firstName',
                                    $qb->expr()->concat($qb->expr()->literal(' '), 'u.middleName'))))
                    ),
                    $qb->expr()->lower(':searchStr')
                )
            )
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->addOrderBy('u.middleName', 'ASC')
            ->setParameter('searchStr', '%' . trim($searchStr) . '%')
            ->getQuery()
            ->getResult();

        return $result;
    }
}
