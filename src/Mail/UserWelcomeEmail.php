<?php

namespace Belt\Core\Mail;

use Belt\Core\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserWelcomeEmail
 * @package Belt\Core\Mail
 */
class UserWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param $params array
     */
    public function __construct($params = [])
    {
        $this->user = array_get($params, 'user');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Welcome To ' . env('APP_NAME'))
            ->view('belt-core::users.emails.welcome')
            ->text('belt-core::users.emails.welcome_plain')
            ->with([
                'user' => $this->user,
            ]);
    }

}
