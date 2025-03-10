<?php

namespace Application\Lib\Classes;

use Application\Lib\Classes\Base;

class Log extends Base 
{

    private int $userId;
    private string $content;
    private \DateTimeImmutable $logDateTime;

    public function __construct(array $log)
    {
        $this->id = $log['log_id'];
        $this->userId = $log['user_id'];
        $this->content = $log['content'];
        $this->logDateTime = $log['log_datetime'];
    }
}