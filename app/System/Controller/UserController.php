<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserController
 * @package App\System\Controller
 * @Controller(prefix="system/user")
 * @Auth
 */
class UserController extends MineController
{

    /**
     * @Inject
     * @var SystemUserService
     */
    protected $systemUserService;

    /**
     * @GetMapping("getListPage")
     * @return ResponseInterface
     * @Permission()
     */
    public function getListPage(): ResponseInterface
    {
        return $this->success();
    }

    /**
     * @PostMapping("create")
     * @return ResponseInterface
     * @Permission()
     */
    public function create(): ResponseInterface
    {
        return $this->success();
    }

    /**
     * @GetMapping("read")
     * @return ResponseInterface
     * @Permission()
     */
    public function read(): ResponseInterface
    {
        return $this->success();
    }

    /**
     * @PutMapping("update")
     * @return ResponseInterface
     * @Permission()
     */
    public function update(): ResponseInterface
    {
        return $this->success();
    }

    /**
     * @DeleteMapping("delete")
     * @return ResponseInterface
     * @Permission()
     */
    public function delete(): ResponseInterface
    {
        return $this->success();
    }

}