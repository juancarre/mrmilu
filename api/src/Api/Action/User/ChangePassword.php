<?php

namespace App\Api\Action\User;

use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\ChangePasswordService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ChangePassword
{
    private ChangePasswordService $changePasswordService;

    /**
     * ChangePassword constructor.
     * @param ChangePasswordService $changePasswordService
     */
    public function __construct(ChangePasswordService $changePasswordService)
    {
        $this->changePasswordService = $changePasswordService;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, string $id): User
    {
        return $this->changePasswordService->changePassword(
            $id,
            RequestService::getField($request, 'newPassword'),
            RequestService::getField($request, 'oldPassword')
        );
    }
}
