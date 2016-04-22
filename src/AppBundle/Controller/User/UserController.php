<?php

namespace AppBundle\Controller\User;

use CoreDomain\DTO\User\ProfileDTO;
use CoreDomain\DTO\User\UserRegisterDTO;
use CoreDomain\Exception\AccessDeniedException;
use CoreDomain\Exception\ValidationException;
use CoreDomain\Model\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UserController extends Controller
{
    /**
     * @Rest\Post("/users")
     * @Rest\View(serializerGroups="api_user_get", statusCode=201)
     * @ParamConverter(
     *      "userDTO",
     *      converter="fos_rest.request_body",
     *      options={
     *          "deserializationContext"={"groups"="api_user_post"},
     *          "validator"={"groups"={"api_user_post"}}
     *      }
     * )
     */
    public function createUserAction(UserRegisterDTO $userDTO, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException('Bad request', $validationErrors);
        }

        return $this->get('app.managers.user.user')->register($userDTO);
    }

    /**
     * @Rest\Get("/users/{id}")
     * @Rest\View(serializerGroups="api_user_get", statusCode=200)
     */
    public function getUserAction(User $user)
    {
        $this->checkAccess($user);
        return $user;
    }

    /**
     * @Rest\Patch("/users/{id}")
     * @Rest\View(serializerGroups="api_user_get", statusCode=200)
     * @ParamConverter(
     *      "profileDTO",
     *      converter="fos_rest.request_body",
     *      options={
     *          "deserializationContext"={"groups"="api_user_patch"},
     *          "validator"={"groups"={"api_user_patch"}}
     *      }
     * )
     */
    public function updateProfileAction(User $user, ProfileDTO $profileDTO, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException('Bad request', $validationErrors);
        }
        return $this->get('app.managers.user.user')->updateProfile($user, $profileDTO);
        //$this->checkAccess($user);
    }

    private function checkAccess(User $user)
    {
        $currentUser = $this->getUser();
        if (!$currentUser || $currentUser->getId() !== $user->getId()) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Rest\Delete("/users/{id}")
     * @Rest\View(statusCode=204)
     */
    public function deleteUserAction(User $user)
    {
        $this->get('app.managers.user.user')->deleteUser($user);
    }

    /**
     * @Rest\Get("/users")
     * @Rest\View(serializerGroups="api_user_get", statusCode=201)
     */
    public function getUsersByRoleAction()
    {
        $role = $this->get('request')->query->get('role');
        return $this->get('app.managers.user.user')->getUsersByRole($role);
    }

    /**
     * @Rest\Get("/users/search")
     * @Rest\View(serializerGroups="api_user_search", statusCode=201)
     */
    public function searchUserAction()
    {
        $searchStr = $this->get('request')->query->get('fullname');
        return $this->get('app.managers.user.user')->searchUser($searchStr);
    }
}
