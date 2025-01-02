<?php

namespace App\Http\Controllers;
use App\Models\TimeTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TimeTrackingController
{

    public function list() {
        $groupedList = [];
        $list = TimeTracking::whereNotNull("started_at")->whereNotNull("ended_at")->get()->all();

        foreach ($list as $listItem) {
            $type = $listItem->type;
            $startedTime = Carbon::parse($listItem->started_at);
            $endedTime = Carbon::parse($listItem->ended_at);

            $minutes = $startedTime->diffInMinutes($endedTime);

            if (!array_key_exists($type, $groupedList)) {
                $groupedList[$type] = [ 'minutes' => 0, 'last_updated' => null ];
            }

            $groupedList[$type]['minutes'] += ceil($minutes);
            $groupedList[$type]['last_updated'] = $endedTime->diffForHumans();
        }

        ksort($groupedList);

        return view('timetracking.list', ['trackers' => $groupedList]);
    }

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
