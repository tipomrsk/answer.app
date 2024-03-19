<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\FormFullyAnswered;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new FormFullyAnswered(
            'Form fully answered',
            'You have a new form fully answered',
            "Nice Link!",
            "https://www.youtube.com/watch?v=uH64qV71uUQ",
            "Thank you for using our application",
            $this->email
        ))->notify();
    }
}
