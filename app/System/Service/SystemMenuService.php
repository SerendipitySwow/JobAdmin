<?php
declare(strict_types=1);
namespace App\System\Service;


use App\System\Mapper\SystemMenuMapper;
use App\System\Model\SystemMenu;
use Mine\Abstracts\AbstractService;

class SystemMenuService extends AbstractService
{
    /**
     * @var SystemMenuMapper
     */
    public $mapper;

    /**
     * SystemMenuMapper constructor.
     * @param SystemMenuMapper $mapper
     */
    public function __construct(SystemMenuMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param array|null $params
     * @return array
     */
    public function getTreeList(?array $params = null): array
    {
        $params = array_merge(['order_by' => 'sort', 'order_type' => 'desc'], $params);
        return parent::getTreeList($params);
    }

    /**
     * @param array|null $params
     * @return array
     */
    public function getTreeListByRecycle(?array $params = null): array
    {
        return parent::getTreeListByRecycle(['order_by' => 'sort', 'order_type' => 'desc']);
    }

    /**
     * 获取前端选择树
     * @return array
     */
    public function getSelectTree(): array
    {
        return $this->mapper->getSelectTree();
    }

    /**
     * @param string $code
     * @return string
     */
    public function findNameByCode(string $code): string
    {
        if (strlen($code) < 1) {
            return __('system.undefined_menu');
        }
        $name = $this->mapper->findNameByCode($code);
        return $name ? $name : __('system.undefined_menu');
    }

    /**
     * 新增菜单
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $pid = $data['parent_id'] ?? 0;
        // 顶层菜单
        if ($pid === 0) {
            $data['level'] = $data['parent_id'] = '0';
            $data['type'] = SystemMenu::TYPE_CLASSIFY;
        } else {
            $data['parent_id'] = array_pop($data['parent_id']);
            $data['level'] = implode(',', $pid);
            $menu = $this->mapper->read((int) $data['parent_id']);
            if ($data['type'] != SystemMenu::TYPE_CLASSIFY && $data['type'] != SystemMenu::BUTTON) {
                $code = explode('-', $menu['code']);
                (count($code) > 1) && array_pop($code);
                $data['code'] = sprintf('%s-%s', implode('-', $code), $data['code']);
            } else {
                $data['code'] = sprintf('%s-%s', $menu['code'], $data['code']);
            }
        }

        $id = $this->mapper->save($data);

        // 生成RESTful按钮菜单
        if ($data['type'] == SystemMenu::MENUS_LIST && $data['restful'] == '0') {
            $this->genButtonMenu(explode(',', $data['level'].','.$id));
        }
        return $id;
    }

    /**
     * 生成按钮菜单
     * @param array $parent_id
     * @return bool
     */
    public function genButtonMenu(array $parent_id): bool
    {
        $btns = [
            ['name' => '列表', 'code' => 'index'],
            ['name' => '保存', 'code' => 'save'],
            ['name' => '更新', 'code' => 'update'],
            ['name' => '删除', 'code' => 'delete'],
            ['name' => '读取', 'code' => 'read'],
            ['name' => '恢复', 'code' => 'recovery'],
            ['name' => '真实删除', 'code' => 'realDelete']
        ];

        foreach ($btns as $btn) {
            $this->save(
                array_merge(
                    ['parent_id' => $parent_id, 'type' => SystemMenu::BUTTON],
                    $btn
                )
            );
        }

        return true;
    }

    /**
     * 更新菜单
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $pid = $data['parent_id'] ?? 0;
        // 顶层菜单
        if ($pid === 0) {
            $data['level'] = $data['parent_id'] = '0';
            $data['type'] = SystemMenu::TYPE_CLASSIFY;
        } else {
            if (is_array($data['parent_id'])) {
                $data['parent_id'] = array_pop($data['parent_id']);
                $data['level'] = implode(',', $pid);
            } else {
                $data['level'] = $data['parent_id'];
            }
            $menu = $this->mapper->read((int) $data['parent_id']);
            if ($data['type'] != SystemMenu::TYPE_CLASSIFY && $data['type'] != SystemMenu::BUTTON) {
                $code = explode('-', $menu['code']);
                (count($code) > 1) && array_pop($code);
                $curCode = explode('-', $data['code']);
                $data['code'] = sprintf('%s-%s', implode('-', $code), array_pop($curCode));
            } else {
                $data['code'] = sprintf('%s-%s', $menu['code'], $data['code']);
            }
        }
        return $this->mapper->update($id, $data);
    }

    /**
     * 真实删除菜单
     * @param string $ids
     * @return array
     */
    public function realDel(string $ids): ?array
    {
        $ids = explode(',', $ids);
        // 跳过的菜单
        $ctuIds = [];
        if (count($ids)) foreach ($ids as $id) {
            if (!$this->checkChildrenExists( (int) $id)) {
                $this->mapper->realDelete([$id]);
            } else {
                array_push($ctuIds, $id);
            }
        }
        return count($ctuIds) ? $this->mapper->getMenuName($ctuIds) : null;
    }

    /**
     * 检查子菜单是否存在
     * @param int $id
     * @return bool
     */
    public function checkChildrenExists(int $id): bool
    {
        return $this->mapper->checkChildrenExists($id);
    }
}