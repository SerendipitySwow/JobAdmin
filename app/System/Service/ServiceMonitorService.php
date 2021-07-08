<?php

declare(strict_types=1);
namespace App\System\Service;


use Hyperf\Utils\Filesystem\Filesystem;

class ServiceMonitorService
{
    /**
     * 获取cpu信息
     * @return array
     */
    public function getCpuInfo(): array
    {
        $cpu = $this->getCpuUsage();
        preg_match('/(\d+)/', shell_exec('cat /proc/cpuinfo | grep "cache size"'), $cache);
        return [
            'name'  => $this->getCpuName(),
            'cores' => 'CPU物理核心数：'.$this->getCpuPhysicsCores().'，CPU逻辑核心数：'.$this->getCpuLogicCores(),
            'cache' => $cache[1] / 1024,
            'usage' => $cpu,
            'free'  => 100 - $cpu
        ];
    }

    /**
     * 获取CPU名称
     * @return string
     */
    public function getCpuName(): string
    {
        $string = shell_exec('cat /proc/cpuinfo | grep name | cut -f2 -d: | uniq -c');
        preg_match('/^\s+\d\s+(.+)/', $string, $matches);
        return $matches[1];
    }

    /**
     * 获取cpu物理核心数
     */
    public function getCpuPhysicsCores(): string
    {
        $string = shell_exec('cat /proc/cpuinfo |grep "physical id"|sort |uniq|wc -l');
        return str_replace("\n", '', $string);
    }

    /**
     * 获取cpu逻辑核心数
     */
    public function getCpuLogicCores(): string
    {
        $string = shell_exec('cat /proc/cpuinfo |grep "processor"|wc -l');
        return str_replace("\n", '', $string);
    }

    /**
     * 获取CPU使用率
     * @return array
     */
    public function getCpuUsage(): string
    {
        $start = $this->calculationCpu();
        sleep(1);
        $end   = $this->calculationCpu();

        $totalStart = $start['total'];
        $totalEnd = $end['total'];

        $timeStart = $start['time'];
        $timeEnd = $end['time'];

        unset($start, $end);

        return sprintf('%.2f', ($timeEnd - $timeStart) / ($totalEnd - $totalStart) * 100);
    }

    /**
     * 计算CPU
     * @return array
     */
    protected function calculationCpu(): array
    {
        $mode = '/(cpu)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/';
        $string = shell_exec('more /proc/stat | grep cpu');
        preg_match_all($mode, $string,$matches);

        $total = $matches[2][0] + $matches[3][0] + $matches[4][0] + $matches[5][0] + $matches[6][0] + $matches[7][0] + $matches[8][0] + $matches[9][0];
        $time  = $matches[2][0] + $matches[3][0] + $matches[4][0] + $matches[6][0] + $matches[7][0] + $matches[8][0] + $matches[9][0];

        return ['total' => $total, 'time' => $time];
    }

    /**
     * 获取内存信息
     * @return array
     */
    public function getMemInfo(): array
    {
        $string = shell_exec('cat /proc/meminfo | grep MemTotal');
        preg_match('/(\d+)/', $string, $total);
        $result['total'] = sprintf('%.2f', $total[1] / 1024 / 1024);

        $string = shell_exec('cat /proc/meminfo | grep MemFree');
        preg_match('/(\d+)/', $string, $free);
        $result['free'] = sprintf('%.2f', $free[1] / 1024 / 1024);

        $result['usage'] = sprintf('%.2f', ($total[1] - $free[1]) / 1024 / 1024);

        $result['php'] = round(memory_get_usage()/1024/1024, 2);

        $result['rate'] = sprintf(
            '%.2f', (sprintf('%.2f', $result['usage']) / sprintf('%.2f', $result['total'])) * 100
        );

        unset($total, $free, $project);

        return $result;
    }

    /**
     * 获取PHP及环境信息
     */
    public function getPhpAndEnvInfo()
    {
        // swoole 版本
        preg_match('/(\d\.\d\.\d)/', shell_exec('php --ri swoole | grep Version'), $matches);
        $result['swoole_version'] = $matches[1];
        // PHP 版本
        $result['php_version'] = PHP_VERSION;
        // OS
        $result['os'] = PHP_OS;
        // 项目地址
        $result['project_path'] = BASE_PATH;
        // 程序启动时间
        $result['start_time'] = date('Y-m-d H:i:s', START_TIME);
        // 程序运行时长
        $result['run_time'] = \Mine\Helper\Str::Sec2Time(time() - START_TIME);
        // 系统版本
        $result['mineadmin_version'] = \Mine\Mine::getVersion();
        // hyperf框架版本
        preg_match('/(\d\.\d\.\d)/', shell_exec('composer info | grep hyperf/framework'), $hv);
        $result['hyperf_version'] = $hv[1];

        return $result;
    }

}