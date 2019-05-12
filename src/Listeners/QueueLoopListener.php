<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-12
 * Time: 16:51
 */

namespace Sky\BaseQueue\Listeners;

use Sky\BaseQueue\Events\QueueLoopEvent;

class QueueLoopListener extends BaseListener
{
    public function handle(QueueLoopEvent $event)
    {

    }
}