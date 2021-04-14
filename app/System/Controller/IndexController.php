<?php
declare(strict_types=1);
namespace App\System\Controller;

use App\System\Model\SystemUser;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Mine;
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
//        $systemUser = new SystemUser;
//        $data = $systemUser->get();
//        $data2 = $systemUser->find($data[0]->id);
//        return $this->success($data2);

        $mine = new Mine();

        return $this->success($mine->getModuleInfo());
    }
}