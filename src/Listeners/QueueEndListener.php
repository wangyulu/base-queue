<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 15:43
 */

namespace Lxk\BaseQueue\Listeners;

use Log;
use Lxk\BaseQueue\Models\QueueModel;
use Lxk\BaseQueue\Events\QueueEndEvent;
use Lxk\BaseQueue\Models\QueueLogModel;

class QueueEndListener extends BaseListener
{
    public function handle(QueueEndEvent $event)
    {
        $queue = $this->getQueueByClassName($event->getClassName());
        if (!$queue) {
            Log::error('消息未找到', [$event->getClassName()]);
            return;
        }

        $this->setQueueStatusToEnd($queue);

        $logQuery = QueueLogModel::query();
        $data     = [
            'queue_id'       => $queue->id,
            'queue_uuid'     => $event->getQueueUuid(),
            'status'         => QueueModel::STATUS_SUCC,
            'execution_time' => getExecTime()
        ];

        $logQuery->updateOrCreate(array_only($data, ['queue_uuid', 'queue_id']), $data);

        Log::info('【end】', [get_class($event)]);
    }
}