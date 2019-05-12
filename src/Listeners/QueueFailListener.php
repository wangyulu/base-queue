<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 15:43
 */

namespace Sky\BaseQueue\Listeners;

use Log;
use Sky\BaseQueue\Events\QueueFailEvent;

class QueueFailListener extends BaseListener
{
    public function handle(QueueFailEvent $event)
    {
        Log::info('【fail】', [get_class($event)]);
    }
}