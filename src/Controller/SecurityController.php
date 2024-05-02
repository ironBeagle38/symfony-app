<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserProviderInterface $userProvider,
        JWTTokenManagerInterface $JWTManager,
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$username || !$password) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $userProvider->loadUserByIdentifier($username);
        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $token = $JWTManager->create($user);
            return new JsonResponse(['token' => $token]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}