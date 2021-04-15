<?php
declare(strict_types=1);

namespace Mine;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Request;
use Mine\Helper\LoginUser;

class MineRequest extends Request
{
    /**
     * @Inject
     * @var MineResponse
     */
    protected $response;

    /**
     * @Inject
     * @var LoginUser
     */
    protected $loginUser;

    /**
     * @return LoginUser
     */
    public function getLoginUser(): LoginUser
    {
        return $this->loginUser;
    }

}

