<?php

namespace App\System\Vo;

/**
 * 队列消息内容对象
 * Class QueueMessageVo
 * @package App\System\Vo
 */
class QueueMessageVo
{
    /**
     * 消息标题
     * @var string
     */
    protected $title;

    /**
     * 消息类型
     * @var string
     */
    protected $contentType;

    /**
     * 消息内容
     * @var string
     */
    protected $content;

    /**
     * 发送人
     * @var string
     */
    protected $sendBy;

    /**
     * 发送状态
     * @var string
     */
    protected $sendStatus;

    /**
     * 备注
     * @var string
     */
    protected $remark;

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSendBy(): string
    {
        return $this->sendBy;
    }

    /**
     * @param string $sendBy
     */
    public function setSendBy(string $sendBy): void
    {
        $this->sendBy = $sendBy;
    }

    /**
     * @return string
     */
    public function getSendStatus(): string
    {
        return $this->sendStatus;
    }

    /**
     * @param string $sendStatus
     */
    public function setSendStatus(string $sendStatus): void
    {
        $this->sendStatus = $sendStatus;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
    }


}