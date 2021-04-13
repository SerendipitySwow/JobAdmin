<?php
declare(strict_types=1);
namespace App\System\Controller;

use App\System\Model\SystemUser;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\MineController;
use \Psr\Http\Message\ResponseInterface;

/**
 * Class IndexController
 * @Controller(prefix="system/index")
 * @package App\MineServer\Controller
 */
class IndexController extends MineController
{
    /**
     * @GetMapping("/")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $systemUser = new SystemUser;
        $systemUser->username = rand(0, 100000);
        $systemUser->password = '321';
        $systemUser->save();
        return $this->success();
    }
}