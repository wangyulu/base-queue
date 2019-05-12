<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-12
 * Time: 16:46
 */

namespace Sky\BaseQueue\Events;

class QueueExcepEvent extends BaseEvent
{
    public function __construct($event)
    {
        parent::__construct($event);
    }
}