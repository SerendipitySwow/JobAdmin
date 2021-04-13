<?php
declare(strict_types=1);
namespace Mine\Aspect;

use http\Exception\RuntimeException;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;

/**
 * Class GenIdAspect
 * @package Mine\Aspect
 * @Aspect
 */
class GenIdAspect extends AbstractAspect
{
    public $classes = [
        'Mine\MineModel::save'
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        print_r($proceedingJoinPoint);
        $result = $proceedingJoinPoint->process();
        // 在调用后进行某些处理
        return $result;
    }
}