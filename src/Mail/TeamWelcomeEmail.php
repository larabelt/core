<?php

namespace Belt\Core\Mail;

use Belt\Core\Team;
use Belt\Core\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class TeamWelcomeEmail
 * @package Belt\Core\Mail
 */
class TeamWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Team
     */
    public $team;

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
        $this->team = array_get($params, 'team');
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
            ->subject('New Team For ' . env('APP_NAME'))
            ->view('belt-core::teams.emails.welcome')
            ->text('belt-core::teams.emails.welcome_plain')
            ->with([
                'team' => $this->team,
                'user' => $this->user,
            ]);
    }

}
