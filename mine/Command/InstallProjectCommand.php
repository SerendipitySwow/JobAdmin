<?php

namespace Mine\Command;

use Hyperf\Command\Annotation\Command;
use Mine\MineCommand;
use Mine\Mine;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class InstallProjectCommand
 * @Command
 * @package Mine\Command
 */
class InstallProjectCommand extends MineCommand
{
    /**
     * 安装命令
     * @var string
     */
    protected $name = 'mine:install';

    protected CONST CONSOLE_GREEN_BEGIN = "\033[32;5;1m";
    protected CONST CONSOLE_RED_BEGIN = "\033[31;5;1m";
    protected CONST CONSOLE_END = "\033[0m";

    protected $database = [];

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php mine:install" install MineAdmin system');
        $this->setDescription('MineAdmin system install command');

        $this->addOption('option', '-o', InputOption::VALUE_OPTIONAL, 'input "-o reset" is re install MineAdmin');
    }

    public function handle()
    {
        // 获取参数
        $option = $this->input->getOption('option');


        // 全新安装
        if ($option === null) {
            // 欢迎
            $this->welcome();

            // 检测环境
            $this->checkEnv();

            // 设置数据库
            $this->setDataBaseInformation();

            // 初始化数据
            $this->initData();

            // 安装完成
            //$this->finish();
        }

        // 重新安装
        if ($option === 'reset') {
            echo 123;
        }
    }

    protected function welcome()
    {
        $this->line('-----------------------------------------------------------');
        $this->line('Hello, welcome use MineAdmin system.');
        $this->line('The installation is about to start, just a few steps');
        $this->line('-----------------------------------------------------------');
    }

    protected function checkEnv()
    {
        $answer = $this->ask('Do you want to test the system environment now? (Y/N)');

        if ($this->isYes($answer)) {

            $this->line(PHP_EOL . ' Checking environmenting...' . PHP_EOL);

            if (version_compare(PHP_VERSION, '7.3.0', '<')) {
                $this->error(sprintf(' php version should >= 7.3.0 >>> %sNO!%s', self::CONSOLE_RED_BEGIN, self::CONSOLE_END));
                exit;
            }
            $this->line(sprintf(" php version %s >>> %sOK!%s", PHP_VERSION, self::CONSOLE_GREEN_BEGIN, self::CONSOLE_END));

            $extensions = ['swoole', 'mbstring', 'json', 'openssl', 'pdo', 'xml'];

            foreach($extensions as $ext) {
                $this->checkExtension($ext);
            }
        }
    }

    protected function setDataBaseInformation(): void
    {
        $answer = $this->ask('Do you need to set Database information? (Y/N)');
        // 设置数据库
        if ($this->isYes($answer)) {
            $dbchar = $this->ask('please input database charset, default (utf8mb4)');
            $dbname = $this->ask('please input database name, default(mineadmin)');
            $dbhost = $this->ask('please input database host, default (127.0.0.1)');
            $dbport = $this->ask('please input database host port, default (3306)');
            $prefix = $this->ask('please input table prefix, default (null)');
            $dbuser = $this->ask('please input database username, default (root)');
            $dbpass = '';

            $i = 3;
            while($i > 0) {
                if ($i === 3) {
                    $dbpass = $this->ask('Please input database password. Press "enter" 3 number of times, not setting the password');
                } else {
                    $dbpass = $this->ask(sprintf('If you don\'t set the database password, please try again press "enter" %d number of times', $i));
                }
                if (!empty($dbpass)) {
                    break;
                } else {
                    $i--;
                }
            }

            $this->database = [
                'charset' => $dbchar ?: 'utf8mb4',
                'dbname'  => $dbname ?: 'mineadmin',
                'dbhost'  => $dbhost ?: '127.0.0.1',
                'dbport'  => $dbport ?: '3306',
                'prefix'  => $prefix ?: '',
                'dbuser'  => $dbuser ?: 'root',
                'dbpass'  => $dbpass ?: '',
            ];

            $this->generatorEnvFile();
        }
    }

    protected function generatorEnvFile()
    {
        try {
            $env = parse_ini_file(BASE_PATH . '/.env.example', true);
            $env['APP_NAME'] = 'MineAdmin';
            $env['APP_ENV'] = 'dev';
            $env['DB_DRIVER'] = 'mysql';
            $env['DB_HOST'] = $this->database['dbhost'];
            $env['DB_PORT'] = $this->database['dbport'];
            $env['DB_DATABASE'] = $this->database['dbname'];
            $env['DB_USERNAME'] = $this->database['dbuser'];
            $env['DB_PASSWORD'] = $this->database['dbpass'];
            $env['DB_CHARSET'] = $this->database['charset'];
            $env['DB_COLLATION'] = sprintf('%s_general_ci', $this->database['charset']);
            $env['DB_PREFIX'] = $this->database['prefix'];
            $env['REDIS_HOST'] = 'localhost';
            $env['REDIS_AUTH'] = '(NULL)';
            $env['REDIS_PORT'] = '6379';
            $env['REDIS_DB'] = '0';

            $envContent = '';
            foreach ($env as $key => $e) {
                if (is_string($e)) {
                    $envContent .= sprintf('%s = %s', $key, $e === '1' ? 'true' : ($e === '' ? '' : $e)) . PHP_EOL. PHP_EOL;
                } else {
                    $envContent .= sprintf('[%s]', $key) . PHP_EOL;
                    foreach ($e as $k => $v) {
                        $envContent .= sprintf('%s = %s', $k, $v === '1' ? 'true' : ($v === '' ? '' : $v)) . PHP_EOL;
                    }
                    $envContent .= PHP_EOL;
                }
            }
            $dsn = sprintf("mysql:host=%s", $this->database['dbhost']);
            $isSuccess = (new \PDO($dsn, $this->database['dbuser'], $this->database['dbpass']))->exec(
                sprintf(
                    'CREATE DATABASE IF NOT EXISTS %s DEFAULT CHARSET %s COLLATE %s_general_ci;',
                    $this->database['dbname'], $this->database['charset'], $this->database['charset']
                )
            );

            if ($isSuccess) {
                $this->line($this->getGreenText(sprintf('"%s" database created successfully', $this->database['dbname'])));
                file_put_contents(BASE_PATH . '/.env', $envContent);
            } else {
                $this->line($this->getRedText(sprintf('Failed to create database "%s". Please create it manually', $this->database['dbname'])));
            }

        } catch (\RuntimeException $e) {
            $this->line($this->getRedText($e->getMessage()));
            exit;
        }
    }

    protected function initData()
    {

    }

    protected function finish(): void
    {
        $this->line(sprintf('
/---------------------- welcome to use -----------------------\
|               _                ___       __          _      |
|    ____ ___  (_)___  _____    /   | ____/ /___ ___  (_)___  |
|   / __ `__ \/ / __ \/ ___/   / /| |/ __  / __ `__ \/ / __ \ |
|  / / / / / / / / / / /__/   / ___ / /_/ / / / / / / / / / / |
| /_/ /_/ /_/_/_/ /_/\___/   /_/  |_\__,_/_/ /_/ /_/_/_/ /_/  |
|                                                             |
\_____________  Copyright MineAdmin 2021 ~ %s  _____________|

MineAdmin Version: %s
default username: admin
default password: admin123
    ', date('Y'), Mine::getVersion()));
    }

    /**
     * @param $extension
     */
    protected function checkExtension($extension): void
    {
        if (!extension_loaded($extension)) {
            $this->line(sprintf(" %s extension not install >>> %sNO!%s", $extension, self::CONSOLE_RED_BEGIN, self::CONSOLE_END));
            exit;
        }
        $this->line(sprintf(' %s extension is installed >>> %sOK!%s', $extension, self::CONSOLE_GREEN_BEGIN, self::CONSOLE_END));
    }

    /**
     * @param string $answer
     * @return bool
     */
    protected function isYes(string $answer): bool
    {
        return $answer === 'Y' || $answer === 'y' || $answer === 'yes' || $answer === 'YES';
    }
}
