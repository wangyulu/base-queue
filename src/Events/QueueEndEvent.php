<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 15:36
 */

namespace Lxk\BaseQueue\Events;

class QueueEndEvent extends BaseEvent
{
    public function __construct($event)
    {
        parent::__construct($event);
    }
}