<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-09
 * Time: 14:14
 */

namespace Lxk\BaseQueue\Librarys;

trait EventMap
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Lxk\BaseQueue\Events\QueueCreateEvent' => [
            'Lxk\BaseQueue\Listeners\QueueCreateListener',
        ],
        'Lxk\BaseQueue\Events\QueueStartEvent'  => [
            'Lxk\BaseQueue\Listeners\QueueStartListener',
        ],
        'Lxk\BaseQueue\Events\QueueEndEvent'    => [
            'Lxk\BaseQueue\Listeners\QueueEndListener',
        ],
        'Lxk\BaseQueue\Events\QueueFailEvent'   => [
            'Lxk\BaseQueue\Listeners\QueueFailListener',
        ],
    ];
}