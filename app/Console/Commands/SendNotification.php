<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\FormFullyAnswered;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-notification';

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
        User::all()->each->notify(
            new FormFullyAnswered(
                'Hello!',
                'Your form has been fully answered',
                'View Form',
                'https://www.youtube.com/watch?v=uH64qV71uUQ',
                'Thank you for using our application'
            )
        );
    }
}
