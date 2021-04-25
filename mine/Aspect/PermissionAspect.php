<?php
declare(strict_types=1);
namespace Mine\Aspect;

use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Annotation\Permission;
use Mine\Exception\NoPermissionException;
use Mine\Exception\TokenException;
use Mine\Helper\LoginUser;
use Mine\MineRequest;

/**
 * Class AuthAspect
 * @package Mine\Aspect
 * @Aspect
 */
class PermissionAspect extends AbstractAspect
{

    public $annotations = [
        Permission::class
    ];

    /**
     * @var SystemUserService
     */
    protected $service;

    /**
     * @var MineRequest
     */
    protected $request;

    public function __construct(SystemUserService $service, MineRequest $request)
    {
        $this->service = $service;
        $this->request = $request;
    }

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws \HyperfExt\Jwt\Exceptions\JwtException
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        if ($this->request->getLoginUser()->isSuperAdmin()) {
            return $proceedingJoinPoint->process();
        }
        $routers = $this->service->getInfo()['routers'];
        $pathInfo = $this->request->getPathInfo();
        foreach ($routers as $router) {
            if ($router['route'] === $pathInfo) {
                // 进一步检查
                // TODO...
                return $proceedingJoinPoint->process();
            }
        }
        throw new NoPermissionException(__('system.no_permission') . ' -> ['. $pathInfo.']');
    }
}