<?php
declare(strict_types=1);

namespace Mine\Generator\Traits;

use App\Setting\Model\SettingGenerateColumns;

trait VueSaveGeneratorTraits
{
    /**
     * 获取表单列表代码
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function getFormListCode(SettingGenerateColumns $column): string
    {
        switch ($column->view_type) {
            case 'password':
                return $this->passwordCode($column);
            case 'textarea':
                return $this->textareaCode($column);
            case 'select':
                return $this->selectCode($column);
            case 'radio':
                return $this->radioCode($column);
            case 'checkbox':
                return $this->checkboxCode($column);
            case 'date':
                return $this->dateCode($column);
            case 'image':
                return $this->imageCode($column);
            case 'file':
                return $this->fileCode($column);
            case 'editor':
                return $this->editor($column);
            default:
                return $this->textCode($column);
        }
    }

    /**
     * text
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function textCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * password
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function passwordCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" show-password clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * textareaCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function textareaCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * selectCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function selectCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * radioCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function radioCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * checkboxCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function checkboxCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * dateCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function dateCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * imageCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function imageCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * fileCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function fileCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

    /**
     * editorCode
     * @param SettingGenerateColumns $column
     * @return string
     */
    protected function editorCode(SettingGenerateColumns $column): string
    {
        return <<<VUE

        <el-form-item label="{$column['column_comment']}" prop="{$column['column_name']}">
            <el-input v-model="form.{$column['column_name']}" type="textarea" :rows="3" clearable placeholder="请输入{$column['column_comment']}" />
        </el-form-item>

VUE;
    }

}