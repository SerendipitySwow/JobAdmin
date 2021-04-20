<?php


namespace Mine\Event;


use Mine\MineRequest;

class UserLoginBefore
{
    public $inputData;

    public function __construct(array $inputData)
    {
        $this->inputData = $inputData;
    }
}