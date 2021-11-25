<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Mine\Listener;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Events\QueryExecuted;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\Arr;
use Mine\Helper\Str;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @Listener
 */
class DbQueryExecutedListener implements ListenerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StdoutLoggerInterface
     */
    protected $console;

    public function __construct(StdoutLoggerInterface $console, ContainerInterface $container)
    {
        $this->logger = $container->get(LoggerFactory::class)->get('sql', 'sql');
        $this->console = $console;
    }

    public function listen(): array
    {
        return [
            QueryExecuted::class,
        ];
    }

    /**
     * @param QueryExecuted $event
     */
    public function process(object $event)
    {
        if ($event instanceof QueryExecuted) {
            $sql = $event->sql;
            $offset = 0;
            if (! Arr::isAssoc($event->bindings)) {
                foreach ($event->bindings as $value) {
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    $sql = Str::replaceFirst('?', "{$value}", $sql, $offset);
                }
            }
            env('CONSOLE_SQL') && $this->console->info(sprintf('%s', $sql));
            $this->logger->info(sprintf('[%s] %s', $event->time, $sql));
        }
    }
}
