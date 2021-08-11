<?php
declare(strict_types=1);

namespace Mine\Generator\Traits;

trait MapperGeneratorTraits
{
    /**
     * 获取搜索代码
     * @param $column
     */
    protected function getSearchCode($column)
    {
        switch ($column['query_type']) {
            // 等于
            case 'eq':
                return $this->getSearchPHPString($column['column_name'], '=', $column['column_comment']);
            // 不等
            case 'neq':

                break;
            // 大于
            case 'gt':

                break;
            // 大于等于
            case 'gte':

                break;
            // 小于
            case 'lt':

                break;
            // 小于等于
            case 'lte':

                break;
            // LIKE
            case 'like':

                break;
            // LIKE
            case 'BETWEEN':

                break;
            // 都没有按相等方式处理
            default:

                break;
        }
    }

    /**
     * @param $name
     * @param $mark
     * @param $comment
     * @return string
     */
    protected function getSearchPHPString($name, $mark, $comment): string
    {
        return <<<php

        // {$comment}
        if (isset(\$params['{$name}'])) {
            \$query->where('{$name}', '{$mark}', \$params['{$name}'])
        }

php;
    }


}