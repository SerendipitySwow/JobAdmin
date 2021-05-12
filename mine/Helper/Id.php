<?php
namespace Mine\Helper;

class Id
{
    const twepoch =  1620750646000;

    //机器标识占的位数
    const workerIdBits = 10;

    //毫秒内自增数点的位数
    const sequenceBits = 1;

    protected $workId = 0;

    //要用静态变量
    static $lastTimestamp = -1;

    static $sequence = 0;


    function __construct($workId = 1){
        //机器ID范围判断
        $maxWorkerId = -1 ^ (-1 << self::workerIdBits);
        if($workId > $maxWorkerId || $workId< 0){
            throw new Exception("workerId can't be greater than ".$this->maxWorkerId." or less than 0");
        }
        //赋值
        $this->workId = $workId;
    }

    /**
     * 生成一个ID
     * @return int
     */
    public function getId(): int
    {
        $timestamp = $this->timeGen();
        $lastTimestamp = self::$lastTimestamp;
        //判断时钟是否正常
        if ($timestamp < $lastTimestamp) {
            throw new Exception("Clock moved backwards.  Refusing to generate id for %d milliseconds", ($lastTimestamp - $timestamp));
        }
        //生成唯一序列
        if ($lastTimestamp == $timestamp) {
            $sequenceMask = -1 ^ (-1 << self::sequenceBits);
            self::$sequence = (self::$sequence + 1) & $sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis($lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }
        self::$lastTimestamp = $timestamp;
        //
        //时间毫秒/数据中心ID/机器ID,要左移的位数
        $timestampLeftShift = self::sequenceBits + self::workerIdBits;
        $workerIdShift = self::sequenceBits;
        //组合3段数据返回: 时间戳.工作机器.序列
        return (($timestamp - self::twepoch) << $timestampLeftShift) | ($this->workId << $workerIdShift) | self::$sequence;
    }

    /**
     * @return float
     */
    protected function timeGen(): float
    {
        return (float)sprintf("%.0f", microtime(true) * 1000);
    }

    /**
     * @param $lastTimestamp
     * @return float
     */
    protected function tilNextMillis($lastTimestamp): float
    {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }

}