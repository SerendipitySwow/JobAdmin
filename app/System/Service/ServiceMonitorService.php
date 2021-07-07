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
        return [
            'cpuName'  => $this->getCpuName(),
            'cpuCores' => 'CPU物理核心数：'.$this->getCpuPhysicsCores().'，CPU逻辑核心数：'.$this->getCpuLogicCores(),
            'cpuUsage' => $this->getCpuUsage()
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
    public function getCpuUsage(): array
    {
        $start = $this->calculationCpu();
        sleep(1);
        $end   = $this->calculationCpu();

        $totalStart = $start['total'];
        $totalEnd = $end['total'];

        $timeStart = $start['time'];
        $timeEnd = $end['time'];

        unset($start, $end);

        $result = [];

        foreach ($totalStart as $k => $total) {
            $result[] = sprintf('%.2f', ($timeEnd[$k] - $timeStart[$k]) / ($totalEnd[$k] - $total) * 100);
        }

        return $result;
    }

    /**
     * 计算CPU
     * @return array
     */
    protected function calculationCpu(): array
    {
        $mode = '/(cpu[0-9]?)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/';
        $string = shell_exec('more /proc/stat | grep cpu');
        preg_match_all($mode, $string,$matches);

        $step = count($matches[0]);

        $total = $time = [];

        for ($i = 0; $i < $step; $i++){
            $total[] = $matches[2][$i] + $matches[3][$i] + $matches[4][$i] + $matches[5][$i] + $matches[6][$i] + $matches[7][$i] + $matches[8][$i] + $matches[9][$i];
            $time[]  = $matches[2][$i] + $matches[3][$i] + $matches[4][$i] + $matches[6][$i] + $matches[7][$i] + $matches[8][$i] + $matches[9][$i];
        }

        return ['total' => $total, 'time' => $time];
    }

    public function getMemInfo(): array
    {
        $fs = new Filesystem;
        $string = shell_exec('cat /proc/meminfo | grep MemTotal');
        preg_match('/(\d+)/', $string, $total);
        $result['memTotal'] = sprintf('%.2f%s', $total[1] / 1024 / 1024, 'G');

        $string = shell_exec('cat /proc/meminfo | grep MemFree');
        preg_match('/(\d+)/', $string, $free);
        $result['memFree'] = sprintf('%.2f%s', $free[1] / 1024 / 1024, 'G');

        $result['memUsage'] = sprintf('%.2f%s', ($total[1] - $free[1]) / 1024 / 1024, 'G');

        $pid = $fs->sharedGet(BASE_PATH . '/runtime/hyperf.pid');

        $string = shell_exec('cat /proc/'.$pid.'/status | grep VmRSS');
        preg_match('/(\d+)/', $string, $project);
        $result['memProject'] = sprintf('%.2f%s', $project[1] / 1024 / 1024, 'G');

        $result['memRate'] = sprintf(
            '%.2f%s',
            (sprintf('%.2f', $result['memUsage']) / sprintf('%.2f', $result['memTotal'])) * 100,
            '%'
        );

        unset($total, $free, $project, $fs);

        return $result;
    }

}