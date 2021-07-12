<?php

declare(strict_types=1);
namespace App\System\Service;

use Hyperf\DbConnection\Db;
use Hyperf\Utils\Collection;

/**
 * 依赖服务处理类
 * Class RelyMonitorService
 * @package App\System\Service
 */
class RelyMonitorService
{
    /**
     * 获取依赖包列表
     * @return array
     */
    public function getRelyPackageList(): array
    {
        preg_match_all(
            "/([\w\-\/\d]+)\s+([v|V]?\d+\.\d+\.\d+)\s+(.+)/i",
            shell_exec('composer info'),
            $matches
        );

        $packages = [];
        foreach ($matches[1] as $k => $match) {
            $packages[] = [
                'name' => $match,
                'version' => $matches[2][$k],
                'description' => $matches[3][$k]
            ];
        }
        return $packages;
    }

    /**
     * 获取依赖包分页
     * @param array|null $params
     * @return array
     */
    public function getPackagePageList(?array $params = []): array
    {
        $collect = new Collection(
            $this->getRelyPackageList()
        );

        if ($params['name'] ?? false) {
            $collect = $collect->filter(function ($row) use ($params) {
                return \Mine\Helper\Str::contains($row['name'], $params['name']);
            });
        }

        $data = [];

        foreach ($collect->forPage(
            (int) $params['page'] ?? 1, (int) $params['pageSize'] ?? 10
        )->toArray() as $package) {
            $data[] = $package;
        }

        return [
            'items' => $data,
            'pageInfo' => [
                'total' => $collect->count(),
                'currentPage' => $params['page'] ?? 1,
                'totalPage' => ceil($collect->count() / ($params['pageSize'] ?? 10))
            ]
        ];
    }

    /**
     * 获取依赖包详细信息
     * @param string $name
     * @return array
     */
    public function getPackageDetail(string $name): array
    {
        if (empty($name)) {
            return [];
        }

        preg_match_all(
            "/(\w+)\s+:(.+)/i",
            shell_exec(sprintf('composer info %s', $name)),
            $matches
        );

        $infos = [];

        foreach ($matches[1] as $k => $match) {
            $infos[] = [
                'name'  => $match,
                'value' => $matches[2][$k],
            ];
        }
        return $infos;
    }
}