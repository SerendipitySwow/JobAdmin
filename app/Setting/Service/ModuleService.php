<?php

declare(strict_types=1);
namespace App\Setting\Service;

use Hyperf\Utils\Collection;
use Mine\Generator\ModuleGenerator;
use Mine\Mine;

class ModuleService
{
    /**
     * @var Mine
     */
    public $mine;

    public function __construct(Mine $mine)
    {
        $this->mine = $mine;
    }
    /**
     * 获取表状态分页列表
     * @param array|null $params
     * @return array
     */
    public function getPageList(?array $params = []): array
    {
        // 先扫描模块
        $this->mine->scanModule();
        $collect = new Collection(
            $this->mine->getModuleInfo()
        );

        if ($params['name'] ?? false) {
            $collect = $collect->where('name', $params['name']);
        }

        if ($params['label'] ?? false) {
            $collect = $collect->where('label', $params['label']);
        }

        $data = $collect->forPage($params['page'] ?? 1, $params['pageSize'] ?? 10)->toArray();

        $modules = [];

        foreach ($data as $item) {
            $modules[] = $item;
        }

        return [
            'items' => $modules,
            'pageInfo' => [
                'total' => $collect->count(),
                'currentPage' => $params['page'] ?? 1,
                'totalPage' => ceil($collect->count() / ($params['pageSize'] ?? 10))
            ]
        ];
    }

    /**
     * 创建模块
     * @param array $moduleInfo
     * @return bool
     */
    public function createModule(array $moduleInfo): bool
    {
        /** @var ModuleGenerator $moduleGen */
        $moduleGen = make(ModuleGenerator::class);
        $moduleGen->setModuleInfo($moduleInfo)->createModule();
        return true;
    }
}