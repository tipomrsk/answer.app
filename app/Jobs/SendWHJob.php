<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookServer\WebhookCall;

class SendWHJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url;
    private array $payload;
    private string $secret;


    /**
     * Create a new job instance.
     */
    public function __construct(string $url, array $payload, string $secret)
    {
        $this->url = $url;
        $this->payload = $payload;
        $this->secret = $secret;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        WebhookCall::create()
            ->url($this->url)
            ->payload($this->payload)
            ->useSecret($this->secret)
            ->dispatch();
    }
}
