<?php
namespace Mine\Command\Creater;

use Hyperf\DbConnection\Db;
use Mine\Mine;
use Mine\MineCommand;
use Hyperf\Command\Annotation\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CreateModel
 * @Command
 * @package Mine\Command\Creater
 */
class CreateModel extends MineCommand
{
    protected $name = 'mine:model-gen';

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php mine:model-gen <--module | -M <module>> [--table | -T [table]]"');
        $this->setDescription('Generate model to module according to data table');
    }

    public function handle()
    {
        /** @var $mine Mine */
        $mine = make(Mine::class);
        $module = ucfirst(trim($this->input->getOption('module')));
        $table  = ucfirst(trim($this->input->getOption('table')));

        $moduleInfos = $mine->getModuleInfo();


        if (isset($moduleInfos[$module])) {
            $info = $moduleInfos[$module];
            $path = "app/{$module}/Model";
//            strtolower;
        }

//        $this->call()

    }

    protected function getOptions(): array
    {
        return [
            ['module', '-M', InputOption::VALUE_REQUIRED, 'Please enter the module to be generated'],
            ['table', '-T', InputOption::VALUE_OPTIONAL, 'Which table you want to associated with the Model.']
        ];
    }
}