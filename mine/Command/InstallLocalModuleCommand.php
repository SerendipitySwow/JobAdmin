<?php

namespace Mine\Command;

use Hyperf\Command\Annotation\Command;
use Mine\Helper\ConsoleTable;
use Mine\Mine;
use Mine\MineCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class InstallLocalModuleCommand
 * @Command
 * @package Mine\Command
 */
class InstallLocalModuleCommand extends MineCommand
{
    /**
     * 安装命令
     * @var string
     */
    protected $name = 'mine:module';

    protected $database = [];

    protected $mine;

    public function configure()
    {
        parent::configure();
        $this->mine = make(Mine::Class);
        $this->setHelp('run "php bin/hyperf.php mine:module <module_name> -o install"');
        $this->setDescription('install command of module MineAdmin');
        $this->addArgument(
            'name', InputArgument::REQUIRED,
            'input module name or "list" command show module list'
        );
        $this->addOption(
            'option', '-o', InputOption::VALUE_OPTIONAL,
            'input "-o install" install module or "-o uninstall" uninstall module'
        );
    }

    public function handle()
    {
        $name = $this->input->getArgument('name');
        $option = $this->input->getOption('option');
        $modules = $this->mine->getModuleInfo();

        // 模块名不能叫list，list是展示模块列表
        if ($name === 'list') {
            $table = new ConsoleTable();
            $table->setHeader(['Name', 'Description', 'Version', "Install", "Enable"]);
            foreach ($modules as $mod) {
                $row = [
                  isset($mod['name']) ? $mod['name'] : 'Null',
                  isset($mod['description']) ? $mod['description'] : 'Null',
                  isset($mod['version']) ? $mod['version'] : 'Null',
                  isset($mod['installed']) && $mod['installed'] === true ? 'yes' : 'no',
                  isset($mod['enabled']) && $mod['enabled'] === true ? 'yes' : 'no',
                ];
                $table->addRow($row);
            }
            echo $table->render();
            exit;
        }

        // other module
        if (isset($modules[$name])) {
            if (empty($option)) {
                $this->line($this->getRedText('Please input the operation command for the module: -o install or -o uninstall'));
                exit;
            }
            if ($option === 'install') {
                $this->line(sprintf("Install complete, Please run it again \"%s\" command! ",$this->getGreenText('php bin/hyperf.php start')));
            }
            if ($option === 'uninstall') {
                $input = ucfirst($name) . ' uninstall';
                $answer = $this->ask(sprintf("You are now ready to unload the module for safety. Please input: %s", $this->getRedText($input)));
                if ($input !== $answer) {
                    $this->line('Input error');
                    exit;
                }
                $this->line(sprintf("Uninstall complete, Please run it again \"%s\" command! ",$this->getGreenText('php bin/hyperf.php start')));
            }
        } else {
            $this->line($this->getRedText(sprintf('The "%s" module does not exist....', $name)));
        }
    }
}
