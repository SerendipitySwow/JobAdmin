<?php

declare(strict_types=1);
namespace App\System\Controller\Api;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AppController
 * @package App\System\Controller
 * @Controller(prefix="system\app")
 * @Auth
 */
class AppController extends MineController
{

}