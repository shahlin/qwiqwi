<?php

namespace App\Http\Controllers;
use App\Models\TimeTracking;
use Illuminate\Http\Request;

class TimeTrackingController
{

    public function trackTime(Request $request) {
        $type = $request->query("type");

        if (!$type) {
            return view('timetracking.error');
        }

        $existingStartedTime = TimeTracking::where("type", $type)
            ->whereNotNull("started_at")
            ->whereNull("ended_at")
            ->first();

        if ($existingStartedTime) {
            $this->endTracking($existingStartedTime->id);
            return view('timetracking.ended');
        }

        $this->startTracking($type);
        return view('timetracking.started');
    }

    public function isInProgress(Request $request) {
        $type = $request->query("type");

        if (!$type) {
            return view('timetracking.error');
        }

        $existingStartedTime = TimeTracking::where("type", $type)
            ->whereNotNull("started_at")
            ->whereNull("ended_at")
            ->first();

        if ($existingStartedTime) {
            return response()->json(['in_progress' => true]);
        }

        return response()->json(['in_progress' => false]);
    }

    private function startTracking(string $type) {
        $timeTracking = new TimeTracking();
        $timeTracking->type = $type;
        $timeTracking->started_at = now();
        $timeTracking->save();
    }

    private function endTracking(int $id) {
        TimeTracking::where("id", $id)->update([ "ended_at" => now() ]);
    }

}
