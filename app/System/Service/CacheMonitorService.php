<?php

declare(strict_types=1);
namespace App\System\Service;

use Hyperf\Redis\Redis;

class CacheMonitorService
{
    
    public function getCacheServerInfo()
    {
        $redis = container()->get(Redis::class);

        $info = $redis->info();

        $redisInfo = [
            'version'   => &$info['redis_version'],
            'use_money' => &$info['used_memory_human'],
            'port'      => &$info['tcp_port'],
            'forks_num' => &$info['total_forks'],
            'use_cpu'   => &$info['used_cpu_sys'],
            'clients'   => &$info['connected_clients'],
        ];

        // print_r($redis->keys(config('cache.prefix').'*'));

        return $redisInfo;
    }

}