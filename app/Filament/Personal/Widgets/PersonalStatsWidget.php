<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalStatsWidget extends StatsOverviewWidget
{
    public function getColumns(): int | array
    {
        return [
            'md' => 3,
            'xl' => 3,
        ];
    }


    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', Holiday::where('user_id', Auth::user()->id)->where('type', 'pending')->count()),
            Stat::make('Approved Holidays', Holiday::where('user_id', Auth::user()->id)->where('type', 'accepted')->count()),
            Stat::make('Rejected Holidays', Holiday::where('user_id', Auth::user()->id)->where('type', 'declined')->count()),
            // Stat::make('Total Work', $this->getTotalTime('work')),
            // Stat::make('Total Pause', $this->getTotalTime('pause')),
            Stat::make('Today Work', $this->getTodayTime('work')),
            Stat::make('Today Pause', $this->getTodayTime('pause')),
        ];
    }

    protected function getHeading(): ?string
    {
        return 'Holiday Stats';
    }

    protected function getDescription(): ?string
    {
        return 'Overview of your holiday requests';
    }



    protected function getTotalTime(string $type): string
    {
        $timesheets = Timesheet::where('user_id', Auth::user()->id)
            ->where('type', $type) // 👈 IMPORTANTE
            ->whereNotNull('day_out')
            ->get();

        $totalSeconds = 0;

        foreach ($timesheets as $timesheet) {
            $dayIn = Carbon::parse($timesheet->day_in);
            $dayOut = Carbon::parse($timesheet->day_out);

            if ($dayOut->lt($dayIn)) {
                // Esto no debería pasar → saltamos
                continue;
            }

            $totalSeconds += $dayOut->diffInSeconds($dayIn, true);
        }

        $hours = intdiv($totalSeconds, 3600);
        $minutes = intdiv(($totalSeconds % 3600), 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    protected function getTodayTime(string $type): string
    {
        $timesheets = Timesheet::where('user_id', Auth::user()->id)
            ->where('type', $type) // 👈 IMPORTANTE
            ->whereDate('day_in', Carbon::today())
            ->whereNotNull('day_out')
            ->get();

        $totalSeconds = 0;

        foreach ($timesheets as $timesheet) {
            $dayIn = Carbon::parse($timesheet->day_in);
            $dayOut = Carbon::parse($timesheet->day_out);

            if ($dayOut->lt($dayIn)) {
                // Esto no debería pasar → saltamos
                continue;
            }

            $totalSeconds += $dayOut->diffInSeconds($dayIn, true);
        }

        $hours = intdiv($totalSeconds, 3600);
        $minutes = intdiv(($totalSeconds % 3600), 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
