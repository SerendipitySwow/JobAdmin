<?php


namespace App\Setting\Service;


use App\Setting\Mapper\SettingConfigMapper;
use Hyperf\Config\Annotation\Value;
use Hyperf\Redis\Redis;
use Mine\Abstracts\AbstractService;
use Psr\Container\ContainerInterface;

class SettingConfigService extends AbstractService
{
    /**
     * @var SettingConfigMapper
     */
    public $mapper;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Redis
     */
    protected $redis;

    /**
     * @Value("cache.default.prefix")
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $cacheGroupName;

    /**
     * @var string
     */
    protected $cacheName;

    /**
     * SettingConfigService constructor.
     * @param SettingConfigMapper $mapper
     * @param ContainerInterface $container
     */
    public function __construct(SettingConfigMapper $mapper, ContainerInterface $container)
    {
        $this->mapper = $mapper;
        $this->container = $container;
        $this->setCacheGroupName($this->prefix . 'configGroup:');
        $this->setCacheName($this->prefix . 'config:');
        $this->redis = $this->container->get(Redis::class);
    }

    /**
     * 获取系统组配置
     * @return array
     */
    public function getSystemGroupConfig(): array
    {
        return $this->mapper->getConfigByGroup('system');
    }

    /**
     * 获取扩展组配置
     * @return array
     */
    public function getExtendGroupConfig(): array
    {
        return $this->mapper->getConfigByGroup('extend');
    }

    /**
     * 按组获取配置，并缓存
     * @param string $groupName
     * @return array
     */
    public function getConfigByGroup(string $groupName): array
    {
        if (empty($groupName)) return [];
        $cacheKey = $this->getCacheGroupName() . $groupName;
        if ($data = $this->redis->get($cacheKey)) {
            return unserialize($data);
        } else {
            $data = $this->mapper->getConfigByGroup($groupName);
            if ($data) {
                $this->redis->set($cacheKey, serialize($data));
                return $data;
            }
            return [];
        }
    }

    /**
     * 按key获取配置，并缓存
     * @param string $key
     * @return array
     */
    public function getConfigByKey(string $key): array
    {
        if (empty($key)) return [];
        $cacheKey = $this->getCacheName() . $key;
        if ($data = $this->redis->get($cacheKey)) {
            return unserialize($data);
        } else {
            $data = $this->mapper->getConfigByKey($key);
            if ($data) {
                $this->redis->set($cacheKey, serialize($data));
                return $data;
            }
            return [];
        }
    }

    /**
     * 清除缓存
     * @return bool
     */
    public function clearCache(): bool
    {
        $groupCache = $this->redis->keys($this->getCacheGroupName().'*');
        print_r($groupCache);
        $keyCache = $this->redis->keys($this->getCacheName().'*');
        foreach ($groupCache as $item) {
            $this->redis->del($item);
        }

        foreach($keyCache as $item) {
            $this->redis->del($item);
        }

        return true;
    }

    /**
     * 保存系统配置组
     * @param array $data
     * @return bool
     */
    public function saveSystemConfig(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->mapper->updateConfig($key, $value);
        }
        $this->clearCache();
        return true;
    }

    /**
     * 更新配置
     * @param $data
     * @return bool
     */
    public function updated($data): bool
    {
        $key = $data['key'];
        unset($data['key']);
        return $this->mapper->getModel()::query()->where('key', $key)->update($data);
    }

    /**
     * @return string
     */
    public function getCacheGroupName(): string
    {
        return $this->cacheGroupName;
    }

    /**
     * @param string $cacheGroupName
     */
    public function setCacheGroupName(string $cacheGroupName): void
    {
        $this->cacheGroupName = $cacheGroupName;
    }

    /**
     * @return string
     */
    public function getCacheName(): string
    {
        return $this->cacheName;
    }

    /**
     * @param string $cacheName
     */
    public function setCacheName(string $cacheName): void
    {
        $this->cacheName = $cacheName;
    }


}