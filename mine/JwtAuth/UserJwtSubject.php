<?php

namespace Mine\JwtAuth;

use HyperfExt\Jwt\Contracts\JwtSubjectInterface;

class UserJwtSubject implements JwtSubjectInterface
{
    /**
     * @var array
     */
    protected $userData = [];

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJwtIdentifier(): int
    {
        return (int) ($this->userData['id'] ?? -1);
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJwtCustomClaims(): array
    {
        return $this->userData;
    }
}