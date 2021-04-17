<?php
declare(strict_types=1);
namespace App\System\Controller;

use App\System\Model\SystemUser;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use \Psr\Http\Message\ResponseInterface;

/**
 * Class IndexController
 * @Controller(prefix="system")
 * @package App\MineServer\Controller
 */
class IndexController extends MineController
{
    /**
     * @GetMapping("index")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
//        $systemUser = new SystemUser;
//        $data = $systemUser->get();
//        $data2 = $systemUser->find($data[0]->id);
//        return $this->success($data2);
        return $this->success('asdf');
    }

    /**
     * @return ResponseInterface
     * @GetMapping ("index/token")
     * @Auth
     */
    public function getToken(): ResponseInterface
    {
        $userinfo = [
            'id' => 1610339885485395968,
            'username' => 'admin'
        ];
        return $this->success($this->request->getLoginUser()->getToken($userinfo));
    }

    /**
     * @GetMapping("index/test")
     */
    public function test(): ResponseInterface
    {
        return $this->success();
    }
}