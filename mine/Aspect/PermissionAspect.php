<?php
declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Annotation\Permission;

/**
 * Class PermissionAspect
 * @package Mine\Aspect
 * @Aspect
 */
class PermissionAspect extends AbstractAspect
{

    public $annotations = [
        Permission::class,
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
//        $instance = $proceedingJoinPoint->getInstance();
        $className = $proceedingJoinPoint->className;
        $method = $proceedingJoinPoint->methodName;
        $arguments = $proceedingJoinPoint->arguments;

//        print_r($className);
//        print_r($method);
//        print_r($arguments);
        $permission = $proceedingJoinPoint->getAnnotationMetadata()->class[Permission::class];
//        print_r($permission);
        return $proceedingJoinPoint->process();
    }
}