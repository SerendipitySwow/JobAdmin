<?php


namespace Mine\Event;


use Mine\MineRequest;

class UserLoginAfter
{
    public $userinfo;

    public function __construct(array $userinfo)
    {
        $this->userinfo = $userinfo;
    }
}