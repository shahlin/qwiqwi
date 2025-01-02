<?php

namespace App\Http\Controllers;
use App\Models\TimeTracking;
use Illuminate\Http\Request;

class TimeTrackingAnalyticsController
{

    public function getStats(Request $request) {
        $type = $request->query("type");

        if (!$type) {
            return view('timetracking.error');
        }

        $timeList = TimeTracking::where("type", $type)
            ->whereNotNull("started_at")
            ->whereNotNull("ended_at")
            ->get()
            ->filter(function($time) {
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $time->started_at);
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $time->ended_at);

                return ($from->diffInDays($to) < 1);
            })
            ->values()
            ->all();

        return $timeList;
    }

}