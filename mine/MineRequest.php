<?php
declare(strict_types=1);

namespace Mine;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpServer\Request;
use Mine\Exception\ValidateException;
use Mine\Validate\Validate;
use Psr\Http\Message\ResponseInterface;
use function PHPUnit\Framework\throwException;

class MineRequest extends Request
{
    /**
     * @Inject
     * @var MineResponse
     */
    protected $response;

    /**
     * 数据验证失败的ResponseInterface
     * @var ResponseInterface
     */
    private $validateFailResponse;

    /**
     * 数据验证失败的错误信息
     * @var String
     */
    private $validateError;

    /**
     * 验证数据
     * @access protected
     * @param string $valid
     * @return boolean
     */
    public function validate(string $valid): bool
    {
        $validate = new Validate();

        $valid = new $valid;

        try {
            $validate->message($valid->messages());
            $valid->isBatch() && $validate->batch($valid->isBatch());
            if (!$validate->check($this->all(), $valid->rules())) {
                throw new ValidateException($validate->getError());
            }
            return true;
        } catch (ValidateException $e) {
            $this->validateFailResponse = $this->response->error($e->getError(), [], 500, MineResponse::ERROR_DATA_VALIDATE_FAIL);
            $this->validateError = $e->getError();
            return false;
        }
    }

    /**
     * 获取验证失败的ResponseInterface
     * @return ResponseInterface
     */
    public function getValidateFailResponse(): ResponseInterface
    {
        return $this->validateFailResponse;
    }

    /**
     * @return String
     */
    public function getValidateError(): string
    {
        return $this->validateError;
    }


}

