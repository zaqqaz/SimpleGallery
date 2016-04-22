<?php

namespace CoreDomain\Model\User;

use CoreDomain\DTO\User\ProfileDTO;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User implements AdvancedUserInterface
{

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_TEACHER = 'ROLE_TEACHER';
    const ROLE_CORPORATE = 'ROLE_CORPORATE';

    private $id;
    private $email;
    private $password;
    private $salt;
    private $roles;

    private $lastName;
    private $firstName;
    private $middleName;
    private $phone;
    private $city;
    private $birthday;

    private $status;
    private $lastActivityDate;
    private $lastAuthDate;

    private $settings;

    private $teachers;
    private $students;
    private $employers;
    private $employees;

    // Not mapped, текущая сессия пользователя, инициализируется в ApiProvider
    private $session;

    public function __construct($email, Password $password, array $roles = [])
    {
        $this->email = $email;
        $this->password = $password->getPassword();
        $this->salt = $password->getSalt();
        if (!$roles) {
            $roles = [self::ROLE_USER];
        }
        $this->roles = $roles;
    }

    public function login()
    {
        $this->lastAuthDate = new \DateTime();
        return new UserSession($this);
    }

    public function logout()
    {
        if ($this->session instanceof UserSession) {
            $this->session->finish();
        }
    }

    public function changePassword(Password $password)
    {
        $this->password = $password->getPassword();
        $this->salt = $password->getSalt();
    }

    public function updateProfile(ProfileDTO $dto)
    {
        $this->email = $dto->email;
        $this->lastName = $dto->lastName;
        $this->firstName = $dto->firstName;
        $this->middleName = $dto->middleName;
        $this->phone = $dto->phone;
        $this->city = $dto->city;
        $this->birthday = $dto->birthday;
        $this->roles = $dto->roles;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getTeachers()
    {
        return $this->teachers;
    }

    public function getEmployers()
    {
        return $this->employers;
    }

    public function getStudents()
    {
        return $this->students;
    }

    public function getEmployees()
    {
        return $this->employees;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return true;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession(UserSession $session)
    {
        $this->session = $session;
    }

    public function setTeachers($teachers)
    {
        $this->teachers = $teachers;
    }

    public function setStudents($students)
    {
        $this->students = $students;
    }

    public function setEmployers($employers)
    {
        $this->employers = $employers;
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    public static function getAvailableRoles()
    {
        return [
            self::ROLE_USER,
            self::ROLE_ADMIN,
            self::ROLE_TEACHER,
            self::ROLE_CORPORATE
        ];
    }
}
