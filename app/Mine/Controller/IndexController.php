<?php
declare(strict_types=1);
namespace App\Mine\Controller;

use App\Mine\Request\UserRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\MineController;
use \Psr\Http\Message\ResponseInterface;

/**
 * Class IndexController
 * @Controller(prefix="mine/index")
 * @package App\MineServer\Controller
 */
class IndexController extends MineController
{
    /**
     * @GetMapping("/mine/index")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->success();
    }
}