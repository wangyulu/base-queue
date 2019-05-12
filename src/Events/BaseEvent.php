<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 17:37
 */

namespace Lxk\BaseQueue\Events;

class BaseEvent
{
    public $job;

    public $body;

    public function __construct($event)
    {
        $this->job = $event->job;

        $this->body = json_decode($event->job->getRawBody(), true);
    }

    public function getClassName()
    {
        return array_get($this->body, 'data.commandName', '');
    }

    public function getQueueUuid()
    {
        return array_get($this->body, 'id', '');
    }
}