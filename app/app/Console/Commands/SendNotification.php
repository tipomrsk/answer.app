<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\FormFullyAnswered;
use Illuminate\Console\Command;
use Spatie\WebhookServer\WebhookCall;

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

    }
}
