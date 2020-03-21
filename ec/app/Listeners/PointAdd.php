<?php

namespace App\Listeners;

use App\Events\PointRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PointAdd
{
    private $point;
    private $pointService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(\App\Point $point, \App\Services\PointService $pointService)
    {
        $this->point = $point;
        $this->pointService = $pointService;
    }

    /**
     * Handle the event.
     *
     * @param  PointRegistered  $event
     * @return void
     */
    public function handle(PointRegistered $event)
    {
        // 加算するポイントを計算する
        $addPoint = $this->pointService->pointCalculation(str_replace(',', '', $event->price));

        $userId = $event->user_id;
        // 現在のポイントを取得します
        $pointNow = $this->point->getPoint($userId);

        // ポイントをすでに持っでいたら合算する
        if (!is_null($pointNow)) $addPoint = $this->pointService->pointSum($addPoint, $pointNow->point);

        if ($addPoint > 0) $this->point->updateOrCreatePoint($userId, $addPoint);
    }
}
