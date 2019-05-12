<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 15:42
 */

namespace Lxk\BaseQueue\Listeners;

use Log;
use Lxk\BaseQueue\Models\QueueModel;
use Lxk\BaseQueue\Models\QueueLogModel;
use Lxk\BaseQueue\Events\QueueStartEvent;

class QueueStartListener extends BaseListener
{
    public function handle(QueueStartEvent $event)
    {
        $queue = $this->getQueueByClassName($event->getClassName());
        if (!$queue) {
            Log::error('消息未找到', [$event->getClassName()]);
            return;
        }

        $this->setQueueStatusToRun($queue);

        $logQuery = QueueLogModel::query();
        $data     = [
            'queue_id'   => $queue->id,
            'queue_uuid' => $event->getQueueUuid(),
            'status'     => QueueModel::STATUS_RUN,
        ];

        $logQuery->updateOrCreate(array_except($data, 'status'), $data);

        setQueueStartTime();

        Log::info('【start】', [get_class($event), $event->job]);
    }

    public function getJob()
    {

    }

    public function parse()
    {

    }
}