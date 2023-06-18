<?php

namespace App\Security;

use App\Exception\InvalidIpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WhiteListedIpVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'API_ACCESS' && $subject instanceof Request;
    }

    /**
     * @throws InvalidIpException
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $request = $subject;

        $pathInfo = $request->getPathInfo();

        if (str_starts_with($pathInfo, '/api/')) {
            $clientIp = $request->getClientIp();

            $allowedIps = ['192.168.0.1', '127.0.0.1'];

            if (!in_array($clientIp, $allowedIps)) {
                throw new InvalidIpException($clientIp);
            };

        }

        return true;
    }
}