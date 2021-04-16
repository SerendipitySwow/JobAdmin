<?php

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 用户权限验证。
 * @Annotation
 * @Target("CLASS")
 */
class Permission extends AbstractAnnotation
{
    /**
     * 要验证的路由
     * @var string
     */
    public $auth;
}