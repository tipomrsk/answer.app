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
        WebhookCall::create()
            ->url('https://webhook.site/47a7edd1-8fbb-4620-b8ee-843260e43976')
            ->payload(['key' => 'value'])
            ->useSecret('sign-using-this-secret')
            ->dispatch();
    }
}
