<?php

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use Mine\Helper\LoginUser;

if (! function_exists('container')) {

    /**
     * 获取容器实例
     * @return \Psr\Container\ContainerInterface
     */
    function container(): \Psr\Container\ContainerInterface
    {
        return ApplicationContext::getContainer();
    }

}

if (! function_exists('redis')) {

    /**
     * 获取Redis实例
     * @return \Hyperf\Redis\Redis
     */
    function redis(): \Hyperf\Redis\Redis
    {
        return container()->get(\Hyperf\Redis\Redis::class);
    }

}

if (! function_exists('console')) {

    /**
     * 获取控制台输出实例
     * @return StdoutLoggerInterface
     */
    function console(): StdoutLoggerInterface
    {
        return container()->get(StdoutLoggerInterface::class);
    }

}

if (! function_exists('logger')) {

    /**
     * 获取日志实例
     * @param string $name
     * @return LoggerFactory
     */
    function logger(string $name = 'Log'): LoggerFactory
    {
        return container()->get(LoggerFactory::class)->get($name);
    }

}

if (! function_exists('user')) {

    /**
     * 获取日志实例
     * @return LoginUser
     */
    function user(): LoginUser
    {
        return new LoginUser();
    }

}
