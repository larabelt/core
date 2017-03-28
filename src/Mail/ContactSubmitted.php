<?php
namespace Belt\Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ContactSubmitted
 * @package Belt\Core\Mail
 */
class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $name;
    /**
     * @var mixed
     */
    public $email;
    /**
     * @var mixed
     */
    public $comments;

    /**
     * Create a new message instance.
     *
     * @param $params array
     */
    public function __construct($params = [])
    {
        $this->name = array_get($params, 'name');
        $this->email = array_get($params, 'email');
        $this->comments = array_get($params, 'comments');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('belt-core::contact.emails.submitted')
            ->text('belt-core::contact.emails.submitted_plain');
    }
}
