<?php

namespace App\Listeners;

use App\Events\VerificationCodeGenerated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class SendVerificationCode

{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\VerificationCodeGenerated  $event
     * @return void
     */
    public function handle(VerificationCodeGenerated $event)
    {
        $verificationCode = $event->verificationCode->code;
        $email= $event->verificationCode->user->email;

        Mail::to($email)->send(new VerificationCodeMail($verificationCode));;
    }
}
