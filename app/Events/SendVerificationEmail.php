<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class SendVerificationEmail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    
    public function handle()
    {
        Mail::send([], [], function (Message $message) {
            $message->to($this->user->email)
                ->subject('Email Verification')
                ->setBody(
                    $this->user->confirmation_hash,
                    'Please click the following link to verify your email: ' .
                    route('verification.verify', ['id' => $this->user->id, 'hash' => $this->user->confirmation_hash]),
                    'text/html'
                );
        });
    }
}
