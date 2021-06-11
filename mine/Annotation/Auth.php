<?php

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 用户登录验证。
 * @Annotation
 * @Target({"CLASS","METHOD"})
 */
class Auth extends AbstractAnnotation{}