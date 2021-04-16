<?php
declare(strict_types=1);
namespace App\System\Controller;

use App\System\Model\SystemUser;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Annotation\Permission;
use Mine\Mine;
use Mine\MineController;
use \Psr\Http\Message\ResponseInterface;
use Mine\JwtAuth\UserJwtSubject;
use Hyperf\Di\Annotation\AnnotationCollector;

/**
 * Class IndexController
 * @Controller(prefix="system/index")
 * @package App\MineServer\Controller
 * @Permission(auth="system/index")
 */
class IndexController extends MineController
{
    /**
     * @GetMapping("/")
     * @return ResponseInterface
     * @throws JwtException
     */
    public function index(): ResponseInterface
    {
//        $systemUser = new SystemUser;
//        $data = $systemUser->get();
//        $data2 = $systemUser->find($data[0]->id);
//        return $this->success($data2);
        try {
            $jwt = $this->request->getLoginUser()->getJwt()->getClaim('id');
            return $this->success(['token' => $jwt]);
        } catch (JwtException $e) {
            throw new JwtException($e->getMessage());
        }
    }
}