<?php
declare(strict_types=1);
namespace Mine;

use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\ApplicationContext;
use Mine\Interfaces\MineModelExcel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MineCollection extends Collection
{
    /**
     * 系统菜单转前端路由树
     * @return array
     */
    public function sysMenuToRouterTree(): array
    {
        $data = $this->toArray();
        if (empty($data)) return [];

        $routers = [];
        foreach ($data as $menu) {
            array_push($routers, $this->setRouter($menu));
        }
        return $this->toTree($routers);
    }

    /**
     * @param $menu
     * @return array
     */
    public function setRouter(&$menu): array
    {
        $route = [
            'id' => $menu['id'],
            'parent_id' => $menu['parent_id'],
            'name' => $menu['code'],
            'component' => $menu['component'],
            'path' => '/' . $menu['route'],
            'redirect' => $menu['redirect'],
            'meta' => [
                'type'   => $menu['type'],
                'icon'   => $menu['icon'],
                'title'  => $menu['name'],
                'hidden' => ($menu['is_hidden'] == 0),
                'hiddenBreadcrumb' => false
            ]
        ];
        return $route;
    }

    /**
     * @param array $data
     * @param int $parentId
     * @param string $id
     * @param string $parentField
     * @param string $children
     * @return array
     */
    public function toTree(array $data = [], int $parentId = 0, string $id = 'id', string $parentField = 'parent_id', string $children='children'): array
    {
        $data = $data ?: $this->toArray();

        if (empty($data)) return [];

        $tree = [];

        foreach ($data as $value) {
            if ($value[$parentField] == $parentId) {
                $child = $this->toTree($data, $value[$id]);
                if (!empty($child)) {
                    $value[$children] = $child;
                }
                array_push($tree, $value);
            }
        }

        unset($data);
        return $tree;
    }

    /**
     * 数据导出
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(string $excel, string $filename, $result = null)
    {
        $data = $this->excelExportDataInit($excel, $result);
        $spread = new Spreadsheet();
        $sheet  = $spread->getActiveSheet();
        $filename .= date('Y-m-d_H_i_s'). '.xlsx';
        $filepath = BASE_PATH . '/runtime/' . $filename;
        
        // 表头
        $titleStart = 'A';
        foreach ($data['field'] as $item) {
            $sheet->setCellValue($titleStart . '1', $item['value']);
            $sheet->getStyle($titleStart . '1')->getFont()->setBold(true);
            $titleStart++;
        }

        $generate = $this->yieldExcelData($data['data'], $data['field']);
        
        // 表体
        try {
            $row = 2;
            while ($generate->valid()) {
                $column = 'A';
                foreach ($generate->current() as $value) {
                    $sheet->setCellValue($column . $row, (string) $value);
                    $column++;
                }
                $generate->next();
                $row++;
            }
        } catch (\RuntimeException $e) {}

        $response = ApplicationContext::getContainer()->get(MineResponse::class);
        $writer = IOFactory::createWriter($spread, 'Xlsx');
        ob_start();
        $writer->save('php://output');
        $res = $response->getResponse()
            ->withHeader('Server', 'MineAdmin')
            ->withHeader('content-description', 'File Transfer')
            ->withHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('content-disposition', "attachment; filename=".rawurlencode($filename))
            ->withHeader('content-transfer-encoding', 'binary')
            ->withHeader('pragma', 'public')
            ->withBody(new SwooleStream(ob_get_contents()));
        ob_end_clean();
        $spread->disconnectWorksheets();
        
        return $res;
    }

    /**
     * 数据导入
     */
    public function import(string $excel, $result = null)
    {
    }

    /**
     * excel 数据导出初始化
     * @param string $excel
     * @param null $result
     * @return array
     */
    protected function excelExportDataInit(string $excel, $result = null): array
    {
        $annMate = AnnotationCollector::get($excel);
        $annName = 'Mine\Annotation\ExcelProperty';
        $data = [];

        if (! (new $excel) instanceof MineModelExcel) {
            throw new \RuntimeException();
        }

        if (!isset($annMate['_c'])) {
            throw new \RuntimeException();
        }

        if ($result instanceof \Closure) {
            $data = $result();
        } else if (empty($result)) {
            $data = $this->toArray();
        } else if (is_array($result)) {
            $data = &$result;
        }

        $property = &$annMate['_p'];

        $fields = [];

        foreach ($property as $name => $item) {
            $fields[ $item[$annName]->index ] = [
                'name'  => $name,
                'value' => $item[$annName]->value
            ];
        }

        return ['field' => &$fields, 'data' => &$data];
    }


    private function yieldExcelData(array &$data, array &$field): \Generator
    {
        foreach ($data as $dat) {
            $yield = [];
            foreach ($field as $item) {
                $yield[ $item['name'] ] = $dat[$item['name']] ?? '';
            }
            yield $yield;
        }
    }
}