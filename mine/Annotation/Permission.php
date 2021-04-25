<?php

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 用户权限验证。
 * @Annotation
 * @Target({"METHOD"})
 */
class Permission extends AbstractAnnotation {}