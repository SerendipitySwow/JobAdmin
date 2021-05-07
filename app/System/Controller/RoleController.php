<?php

declare(strict_types = 1);
namespace App\System\Controller;


use App\System\Service\SystemRoleService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Mine\Annotation\Auth;
use Mine\MineController;

/**
 * Class RoleController
 * @package App\System\Controller
 * @Controller(prefix="system/role")
 * @Auth
 */
class RoleController extends MineController
{
    /**
     * @Inject
     * @var SystemRoleService
     */
    protected $service;
}