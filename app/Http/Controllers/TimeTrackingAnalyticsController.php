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
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $time->started_at);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $time->ended_at);

                return ($to->diffInDays($from) == 0);
            });
        
        return $timeList;
    }

}