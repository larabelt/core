<?php

namespace Belt\Core\Forms\Contact;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Belt\Core\Form;

/**
 * Class AutoResponder
 * @package Belt\Core\Forms\Contact
 */
class AutoResponder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Form
     */
    public $form;

    /**
     * Create a new message instance.
     *
     * @param Form $form
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('belt.subtypes.forms.contact.autoresponder.from.email'))
            ->subject('Thank you for contacting us')
            ->view('belt-core::mail.forms.contact.auto-responder')
            ->text('belt-core::mail.forms.contact.auto-responder-plain')
            ->with([
                'data' => $this->form->data,
            ]);
    }
}
