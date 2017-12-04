<?php

namespace Belt\Core\Services;

use Belt, Mail, Validator;
use Belt\Core\Http\Requests\BaseRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\PendingMail;

/**
 * Class ContactService
 * @package Belt\Core\Services
 */
class ContactService
{

    use Belt\Core\Behaviors\HasConfig;

    /**
     * @var array
     */
    public $errors = [];

    /**
     * @var PendingMail
     */
    public $mail;

    /**
     * @var Mailable
     */
    public $mailable;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var string
     */
    public $template = 'default';

    /**
     * @var Validator
     */
    public $validator;

    /**
     * ContactService constructor
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @inheritdoc
     */
    public function configPath()
    {
        return 'belt.core.contact.' . $this->template;
    }

    /**
     * @inheritdoc
     */
    public function configDefaults()
    {
        return [
            'from' => [
                'name' => null,
                'email' => null,
            ],
            'to' => [
                'name' => config('mail.to.name') ?: config('mail.from.name'),
                'email' => config('mail.to.address') ?: config('mail.from.address'),
            ],
            'cc' => null,
            'bcc' => null,
            'request_class' => Belt\Core\Http\Requests\PostContact::class,
            'mailable_class' => Belt\Core\Mail\ContactSubmitted::class,
        ];
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @return Mailable
     */
    public function mailable()
    {
        $mailableClass = $this->config('mailable_class');
        $mailable = new $mailableClass($this->request->all());

        if ($from_email = $this->config('from.email')) {
            $mailable->from($from_email, $this->config('from.name'));
        }

        if ($subject = $this->get('subject')) {
            $mailable->subject($subject);
        }

        return $this->mailable = $mailable;
    }

    /**
     * @return \Illuminate\Mail\MailableMailer|PendingMail
     * @throws \Exception
     */
    public function mail()
    {
        $recipients = $this->users($this->config('to'));

        $mail = Mail::to($recipients);

        if ($cc = $this->get('cc')) {
            $mail->cc($this->users($cc));
        }

        if ($bcc = $this->get('bcc')) {
            $mail->bcc($this->users($bcc));
        }

        return $this->mail = $mail;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = $this->request->get($key);

        return $value ?: $this->config($key, $default);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $requestClass = $this->config('request_class');
        if ($requestClass && is_subclass_of($requestClass, BaseRequestInterface::class)) {
            $request = $requestClass::extend($request);
        }

        if ($template = $request->get('template')) {
            $this->setTemplate($template);
        }

        $this->request = $request;

        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param $template
     * @return $this
     */
    public function setTemplate($template = 'default')
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param null $mailable
     * @param null $mail
     * @throws \Exception
     */
    public function queue($mailable = null, $mail = null)
    {
        $mailable = $mailable ?: $this->mailable();

        $mail = $mail ?: $this->mail();

        $mail->queue($mailable);
    }

    /**
     * @param $users
     * @return array
     * @throws \Exception
     */
    public function users($users)
    {
        if (!is_array($users)) {
            return explode(',', $users);
        }

        if (isset($users['email'])) {
            return [$users];
        }

        if (isset($users[0]['email'])) {
            return $users;
        }

        throw new \Exception('invalid contact users data');
    }

    /**
     * @return bool
     */
    public function validates()
    {
        $this->errors = [];

        $validator = Validator::make(
            $this->request->all(),
            $this->request->rules(),
            $this->request->messages()
        );

        if ($validator->fails()) {
            $this->errors = $validator->messages()->messages();
            return false;
        }

        return true;
    }

}