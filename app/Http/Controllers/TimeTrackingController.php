<?php

namespace App\Http\Controllers;
use App\Models\TimeTracking;

class TimeTrackingController
{

    public function trackTime() {
        $existingStartedTime = TimeTracking::whereNotNull("started_at")->whereNull("ended_at")->first();

        if ($existingStartedTime) {
            $this->endTracking($existingStartedTime->id);
            return view('timetracking.ended');
        }
        
        $this->startTracking();
        return view('timetracking.started');
    }

    private function startTracking() {
        $timeTracking = new TimeTracking();
        $timeTracking->started_at = now();
        $timeTracking->save();
    }

    private function endTracking(int $id) {
        TimeTracking::where("id", $id)->update([ "ended_at" => now() ]);
    }

}
