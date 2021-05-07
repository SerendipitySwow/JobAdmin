<?php

declare(strict_types = 1);
namespace App\System\Controller;


use App\System\Service\SystemPostService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Mine\Annotation\Auth;
use Mine\MineController;

/**
 * Class DeptController
 * @package App\System\Controller
 * @Controller(prefix="system/dept")
 * @Auth
 */
class DeptController extends MineController
{
    /**
     * @Inject
     * @var SystemPostService
     */
    protected $service;
}