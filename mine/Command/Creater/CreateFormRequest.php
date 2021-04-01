<?php
declare(strict_types=1);

namespace Mine\Command\Creater;

use Hyperf\Command\Annotation\Command;
use Hyperf\Utils\Filesystem\FileNotFoundException;
use Hyperf\Utils\Filesystem\Filesystem;
use Hyperf\Utils\Str;
use Mine\MineCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CreateFormRequest
 * @Command
 * @package Mine\Command\Creater
 */
class CreateFormRequest extends MineCommand
{
    protected $name = 'mine:request';

    protected $module;

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php mine:module <module_name> -o install"');
        $this->setDescription('generator validate form request class file');
        $this->addArgument(
            'module', InputArgument::REQUIRED,
            'input module name'
        );

        $this->addArgument(
            'name', InputArgument::REQUIRED,
            'input FormRequest class file name'
        );
    }

    public function handle()
    {
        $this->module = ucfirst(Str::snake(trim($this->input->getArgument('module'))));
        $this->name = ucfirst(Str::snake(trim($this->input->getArgument('name'))));

        $fs = new Filesystem();

        $content = str_replace(
            ['{MODULE_NAME}', '{CLASS_NAME}'],
            [$this->module, $this->name],
            $fs->get($this->getStub('form_request'))
        );

        $fs->put($this->getModulePath() . $this->name . 'FormRequest.php', $content);

        $this->info("<info>[INFO] Created request:</info> ". $this->name . 'FormRequest.php');
    }
}
