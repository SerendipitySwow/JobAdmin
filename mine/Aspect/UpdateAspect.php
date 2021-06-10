<?php
declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\MineModel;
use Mine\MineRequest;

/**
 * Class GenIdAspect
 * @package Mine\Aspect
 * @Aspect
 */
class UpdateAspect extends AbstractAspect
{
    public $classes = [
        'Mine\MineModel::update'
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
        // 更新更改人
        if ($instance instanceof MineModel && in_array('updated_by', $instance->getFillable())) {
            $instance->updated_by = $this->request->getId();
        }
        return $proceedingJoinPoint->process();
    }
}