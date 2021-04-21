<?php
declare(strict_types=1);
namespace App\System\Controller;

use App\System\Model\SystemUser;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use \Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Exception\HttpException;

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
        $url = array_merge($this->request->getServerParams(), $this->request->getHeaders());
        return $this->success($url);
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
        return $this->success($userinfo);
    }

    /**
     * @GetMapping("index/test")
     * @throws \Exception
     */
    public function test(): ResponseInterface
    {
        $systemUser = new SystemUser;
        $data = $systemUser->get();
        $data2 = $systemUser->find($data[0]->id);
        return $this->success($data2);
    }
}