<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemAppMapper;
use App\System\Model\SystemApp;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Mine\Helper\MineCode;

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

    /**
     * @param int|null $id
     * @return array
     */
    public function getApiList(?int $id): array
    {
        if (! $id) return [];

        return $this->mapper->getApiList($id);
    }

    /**
     * 简易验证方式
     * @param string $appId
     * @param string $appSecret
     * @return int
     */
    public function verifyEasyMode(string $appId, string $appSecret): int
    {
        $model = $this->mapper->one(function($query) use($appId, $appSecret){
            $query->where('app_id', $appId)->where('app_secret', $appSecret);
        }, ['id', 'status']);

        if (! $model) {
            return MineCode::API_PARAMS_ERROR;
        }

        if ($model['status'] != SystemApp::ENABLE) {
            return MineCode::APP_BAN;
        }

        return MineCode::API_VERIFY_PASS;
    }

    /**
     * 正常（复杂）验证方式
     * @param string $accessToken
     * @return int
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function verifyNormalMode(string $accessToken): int
    {
        return app_verify()->check($accessToken) ? MineCode::API_VERIFY_PASS : MineCode::API_PARAMS_ERROR;
    }
}