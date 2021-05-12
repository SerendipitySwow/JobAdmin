<?php
declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Mine;
use Mine\MineModel;
use Mine\MineRequest;

/**
 * Class GenIdAspect
 * @package Mine\Aspect
 * @Aspect
 */
class SaveAspect extends AbstractAspect
{
    public $classes = [
        'Mine\MineModel::save'
    ];

    /**
     * @var MineRequest
     */
    protected $request;

    public function __construct(MineRequest $request)
    {
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
        $instance = $proceedingJoinPoint->getInstance();
        // 设置创建人
        if ($instance instanceof MineModel && in_array('created_by', $instance->getFillable())) {
            $instance->created_by = $this->request->getId();
        }
        // 生成ID
        if ($instance instanceof MineModel &&
            !$instance->incrementing &&
            $instance->getPrimaryKeyType() === 'int' &&
            empty($instance->{$instance->getKeyName()})
        ) {
            $instance->setPrimaryKeyValue($instance->genId());
        }
        return $proceedingJoinPoint->process();
    }
}