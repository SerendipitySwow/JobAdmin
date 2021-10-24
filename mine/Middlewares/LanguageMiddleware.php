<?php
declare(strict_types=1);
namespace Mine\Middlewares;

use Hyperf\Contract\ConfigInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LanguageMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $language = explode(',', $request->getHeaderLine('accept-language'))[0] ?? 'zh_CN';
        $config = container()->get(ConfigInterface::class);
        $config->set('translation.locale', $language);
        return $handler->handle($request);
    }
}