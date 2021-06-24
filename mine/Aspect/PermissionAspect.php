<?php
declare(strict_types=1);
namespace Mine\Aspect;

use App\System\Service\SystemMenuService;
use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Annotation\Permission;
use Mine\Exception\NoPermissionException;
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

    /**
     * @var LoginUser
     */
    protected $loginUser;

    /**
     * PermissionAspect constructor.
     * @param SystemUserService $service
     * @param MineRequest $request
     * @param LoginUser $loginUser
     */
    public function __construct(SystemUserService $service, MineRequest $request, LoginUser $loginUser)
    {
        $this->service = $service;
        $this->request = $request;
        $this->loginUser = $loginUser;
    }

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws JwtException
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        if ($this->loginUser->isSuperAdmin()) {
            return $proceedingJoinPoint->process();
        }
        $codes = $this->service->getInfo()['codes'];
        $pathInfo = $this->request->getPathInfo();
        $menu = make(SystemMenuService::class)->mapper->findMenuByRoute($pathInfo);
        if (empty($menu) || !in_array($menu['code'], $codes)) {
            throw new NoPermissionException(__('system.no_permission') . ' -> ['. $pathInfo.']');
        }
        return $proceedingJoinPoint->process();
    }
}