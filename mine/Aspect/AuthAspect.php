<?php
declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use HyperfExt\Jwt\Exceptions\JwtException;
use Mine\Annotation\Auth;
use Mine\Exception\TokenException;
use Mine\Helper\LoginUser;
use Mine\MineRequest;
use Mine\MineResponse;

/**
 * Class AuthAspect
 * @package Mine\Aspect
 * @Aspect
 */
class AuthAspect extends AbstractAspect
{

    public $annotations = [
        Auth::class
    ];

    /**
     * @var LoginUser
     */
    protected $loginUser;

    public function __construct(LoginUser $loginUser)
    {
        $this->loginUser = $loginUser;
    }

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
//        $instance = $proceedingJoinPoint->getInstance();
//        $className = $proceedingJoinPoint->className;
//        $method = $proceedingJoinPoint->methodName;
//        $arguments = $proceedingJoinPoint->arguments;
//
//        $instance = $proceedingJoinPoint->getInstance();
//
//        $permission = $proceedingJoinPoint->getAnnotationMetadata()->class[Auth::class];

        /** @noinspection PhpUnhandledExceptionInspection */
        if ($this->loginUser->check()) {
            return $proceedingJoinPoint->process();
        }
        throw new TokenException(__('jwt.validate_fail'));
    }
}