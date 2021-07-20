<?php
declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Helper\LoginUser;
use Mine\MineModel;

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
        $instance = $proceedingJoinPoint->getInstance();
        // 更新更改人
        if ($instance instanceof MineModel && in_array('updated_by', $instance->getFillable())) {
            $instance->updated_by = $this->loginUser->getId();
        }
        return $proceedingJoinPoint->process();
    }
}