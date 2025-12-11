<?php

namespace App\Console\Commands;

use App\Mail\HolidayPending;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('name', 'Admin')->first();
        // print user email
        echo "Sending test email to: " . $user->email . "\n";
        Mail::to("feligo.dev@gmail.com")->send(new HolidayPending());
    }
}
