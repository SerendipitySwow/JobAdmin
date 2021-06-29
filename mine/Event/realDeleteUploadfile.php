<?php


namespace Mine\Event;


class realDeleteUploadfile
{
    protected $ids;

    protected $confirm = true;

    public function __construct(string $ids)
    {
        $this->ids = !empty($ids) ? explode(',', $ids) : [];
    }

    public function getIds()
    {
        return $this->ids;
    }

    public function getConfirm()
    {
        return $this->confirm;
    }
}