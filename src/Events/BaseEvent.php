<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 17:37
 */

namespace Sky\BaseQueue\Events;

class BaseEvent
{
    public $job;

    public $body;

    public $excep;

    public $payload;

    public $queueUuid;

    public function __construct($event)
    {
        if (property_exists($event, 'job')) {
            $this->job     = $event->job;
            $this->body    = json_decode($event->job->getRawBody(), true);
            $this->payload = $event->job->getRawBody();
        }

        if (property_exists($event, 'exception')) {
            $this->excep = $event->exception;
        }
    }

    public function getClassName()
    {
        return array_get($this->body, 'data.commandName', '');
    }

    public function getQueueUuid()
    {
        return $this->queueUuid ?: array_get($this->body, 'id', '');
    }

    public function getTraceId()
    {
        return array_get($this->body, 'HTTP_X_TRACE_ID', '');
    }

    public function setTraceId()
    {
        $this->getTraceId() && $_SERVER['HTTP_X_TRACE_ID'] = $this->getTraceId();
    }

    public function clearTraceId()
    {
        unset($_SERVER['HTTP_X_TRACE_ID']);
    }

}