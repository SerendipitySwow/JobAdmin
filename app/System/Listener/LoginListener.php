<?php

declare(strict_types=1);
namespace App\System\Listener;

use App\System\Service\SystemLoginLogService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Mine\Event\UserLoginAfter;
use Mine\MineRequest;
use Psr\Container\ContainerInterface;

/**
 * Class LoginListener
 * @Listener
 */
class LoginListener implements ListenerInterface
{
    protected $request;

    protected $sysLoginLogService;

    public function __construct(ContainerInterface $container)
    {
        $this->request = $container->get(MineRequest::class);
        $this->sysLoginLogService = $container->get(SystemLoginLogService::class);
    }

    public function listen(): array
    {
        return [
            UserLoginAfter::class
        ];
    }

    /**
     * @param UserLoginAfter $event
     */
    public function process(object $event)
    {
        $agent = $this->request->getHeader('user-agent')[0];
        $this->sysLoginLogService->save([
            'username' => $event->userinfo['username'],
            'ip' => $this->request->ip(),
            'ip_location' => __('jwt.unknown'),
            'os' => $this->os($agent),
            'browser' => $this->browser($agent),
            'status' => $event->loginStatus,
            'message' => $event->message,
            'login_time' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param $agent
     * @return string
     */
    private function os($agent): string
    {
        if (false !== stripos($agent, 'win') && preg_match('/nt 6.1/i', $agent)) {
            return 'Windows 7';
        }
        if (false !== stripos($agent, 'win') && preg_match('/nt 6.2/i', $agent)) {
            return 'Windows 8';
        }
        if(false !== stripos($agent, 'win') && preg_match('/nt 10.0/i', $agent)) {
            return 'Windows 10';
        }
        if (false !== stripos($agent, 'win') && preg_match('/nt 5.1/i', $agent)) {
            return 'Windows XP';
        }
        if (false !== stripos($agent, 'linux')) {
            return 'Linux';
        }
        if (false !== stripos($agent, 'mac')) {
            return 'mac';
        }
        return __('jwt.unknown');
    }

    /**
     * @param $agent
     * @return string
     */
    private function browser($agent): string
    {
        if (false !== stripos($agent, "MSIE")) {
            return 'MSIE';
        }
        if (false !== stripos($agent, "Edg")) {
            return 'Edge';
        }
        if (false !== stripos($agent, "Firefox")) {
            return 'Firefox';
        }
        if (false !== stripos($agent, "Safari")) {
            return 'Safari';
        }
        if (false !== stripos($agent, "Chrome")) {
            return 'Chrome';
        }
        if (false !== stripos($agent, "Opera")) {
            return 'Opera';
        }
        return __('jwt.unknown');
    }
}