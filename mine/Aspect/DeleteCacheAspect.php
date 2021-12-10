<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Config\Annotation\Value;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Annotation\DeleteCache;
use Mine\Helper\Str;

/**
 * Class DeleteCacheAspect
 * @package Mine\Aspect
 * @Aspect
 */
class DeleteCacheAspect extends AbstractAspect
{
    public $annotations = [
        DeleteCache::class
    ];

    /**
     * 缓存前缀
     * @Value("cache.default.prefix")
     */
    protected $prefix;

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $redis = redis();

        /** @var DeleteCache $deleteCache */
        $deleteCache = $proceedingJoinPoint->getAnnotationMetadata()->method[DeleteCache::class];

        $result = $proceedingJoinPoint->process();

        if ( !empty($deleteCache->keys)) {
            $keys = explode(',', $deleteCache->keys);
            foreach ($keys as $key) {
                if (! Str::contains($key, '*')) {
                    $redis->del("{$this->prefix}{$key}");
                } else {
                    // 删不掉，准备换笨办法。
                    $lua = <<<lua
"local keys = redis.call('keys', ARGV[1]) for i=1,#keys,5000 do redis.call('del', unpack(keys, i, math.min(i+4999, #keys))) end return #keys" 0 '{$this->prefix}{$key}'
lua;
                    $redis->eval($lua);
                }
            }
        }

        return $result;
    }
}