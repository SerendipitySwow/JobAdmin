<?php
declare(strict_types=1);

namespace Mine\Interfaces;

/**
 * 验证器接口
 * Interface DataValid
 * @package MineServer\Lib\Interfaces
 */
interface ValidateInterface
{
    /**
     * 是否批量验证
     * @return bool
     */
    public function isBatch(): bool;

    /**
     * 验证器规则
     * @return array
     */
    public function rules(): array;

    /**
     * 验证器提示信息
     * @return array
     */
    public function messages(): array;

}
