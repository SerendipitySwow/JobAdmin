<?php

declare(strict_types=1);
namespace App\System\Service;

use Hyperf\Redis\Redis;

class CacheMonitorService
{

    /**
     * @return array
     */
    public function getCacheServerInfo(): array
    {
        $redis = container()->get(Redis::class);

        $info = $redis->info();

        $keys = $redis->keys(config('cache.prefix').'*');

        return [
            'keys'      => &$keys,
            'server'    => [
                'version'           => &$info['redis_version'],
                'use_money'         => &$info['used_memory_human'],
                'port'              => &$info['tcp_port'],
                'forks_num'         => &$info['total_forks'],
                'use_cpu'           => &$info['used_cpu_sys'],
                'clients'           => &$info['connected_clients'],
                'executable'        => &$info['executable'],
                'expired_keys'      => &$info['expired_keys'],
                'sys_total_keys'    => count($keys)
            ]
        ];
    }

    /**
     * 删除一个缓存
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return container()->get(Redis::class)->del($key) > 0;
    }

    /**
     * 清空所有缓存
     * @return bool
     */
    public function clear(): bool
    {
        return container()->get(Redis::class)->flushDB();
    }

}