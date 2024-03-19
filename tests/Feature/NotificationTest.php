<?php

use App\Jobs\SendEmailJob;
use App\Jobs\SendWHJob;
use Illuminate\Support\Facades\Mail;

//it('should send webhook notification' , function () {
//
//    SendWHJob::dispatch(
//        'https://webhook.site/47a7edd1-8fbb-4620-b8ee-843260e43976',
//        ["message"=>"test ok"],
//        "secret"
//    );
//});
//
//it('should send email notification' , function () {
//    config(['queue.default' => 'sync']);
//    SendEmailJob::dispatch('christy87@example.com');
//});
