<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemAppMapper;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Mine\Helper\Str;

/**
 * app应用业务
 * Class SystemAppService
 * @package App\System\Service
 */
class SystemAppService extends AbstractService
{
    /**
     * @var SystemAppMapper
     */
    public $mapper;

    public function __construct(SystemAppMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 生成新的app id
     * @return string
     * @throws \Exception
     */
    public function getAppId(): string
    {
        return bin2hex(random_bytes(5));
    }

    /**
     * 生成新的app secret
     * @return string
     * @throws \Exception
     */
    public function getAppSecret(): string
    {
        return base64_encode(bin2hex(random_bytes(32)));
    }

    /**
     * 绑定接口
     * @param int $id
     * @param array $ids
     * @return bool
     * @Transaction
     */
    public function bind(int $id, array $ids): bool
    {
        return $this->mapper->bind($id, $ids);
    }
}