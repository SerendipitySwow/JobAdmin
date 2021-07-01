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
        $params = array_merge(['order_by' => 'sort', 'order_type' => 'desc'], $params);
        return parent::getTreeListByRecycle($params);
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
        return $name ?? __('system.undefined_menu');
    }

    /**
     * 新增菜单
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $id = $this->mapper->save($this->handleData($data));

        // 生成RESTFUL按钮菜单
        if ($data['type'] == SystemMenu::MENUS_LIST && $data['restful'] == '0') {
            $code = $this->mapper->model::where('id', $id)->value('code');
            $this->genButtonMenu($id, $code);
        }

        return $id;
    }

    /**
     * 生成按钮菜单
     * @param int $parent_id
     * @return bool
     */
    public function genButtonMenu(int $parent_id, $code): bool
    {
        $btns = [
            ['name' => '列表', 'code' => $code.':index'],
            ['name' => '保存', 'code' => $code.':save'],
            ['name' => '更新', 'code' => $code.':update'],
            ['name' => '删除', 'code' => $code.':delete'],
            ['name' => '读取', 'code' => $code.':read'],
            ['name' => '恢复', 'code' => $code.':recovery'],
            ['name' => '真实删除', 'code' => $code.':realDelete']
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
        return $this->mapper->update($id, $this->handleData($data));
    }

    /**
     * 处理数据
     * @param $data
     * @return mixed
     */
    protected function handleData($data) {
        if ($data['parent_id'] == 0) {
            $data['level'] = '0';
            $data['type'] = SystemMenu::TYPE_CLASSIFY;
        } else {
            $parentMenu = $this->mapper->read((int) $data['parent_id']);
            $data['level'] = $parentMenu['level'] . ',' . $parentMenu['id'];
        }
        return $data;
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