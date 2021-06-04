<?php

declare(strict_types=1);
namespace App\System\Controller\Monitor;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;

/**
 * Class SystemInfoController
 * @package App\System\Controller\Monitor
 * @Controller(prefix="system/monitor")
 */
class SystemInfoController extends MineController
{
    /**
     * @GetMapping("index")
     */
    public function index()
    {
        $this->getSystemInfo();
    }

    /**
     * 获取系统信息
     */
    protected function getSystemInfo()
    {
        $fp = popen('top -b -n 1 | grep -E "^(Cpu|CPU|Mem)"',"r");
        $content = '';
        while(!feof($fp)) {
            $content .= fread($fp, 1024);
        }
        pclose($fp);
        $content = explode("\n",$content);
        $memony = explode(",",$content[0]); //内存
        $cpu = explode(",",$content[1]); //CPU

        print_r($memony);
        print_r($cpu);
    }


}