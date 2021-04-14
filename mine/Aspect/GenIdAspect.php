<?php
declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\MineModel;

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
        $instance = $proceedingJoinPoint->getInstance();
        if ($instance instanceof MineModel && !$instance->incrementing && $instance->getPrimaryKeyType() === 'int') {
            $instance->setPrimaryKeyValue($instance->genId());
        }
        return $proceedingJoinPoint->process();
    }
}