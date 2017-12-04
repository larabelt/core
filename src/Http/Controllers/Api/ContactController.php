<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt, Mail, Validator;
use Belt\Core\Http\Requests\BaseRequestInterface;
use Belt\Core\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\PendingMail;

/**
 * Class ContactController
 * @package Belt\Core\Http\Controllers\Api
 */
class ContactController extends ApiController
{

    use Belt\Core\Behaviors\HasConfig;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $template = 'default';

    /**
     * @inheritdoc
     */
    public function configPath()
    {
        return 'belt.core.contact.' . $this->template;
    }

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = $this->request->get($key, $default);

        return $value ?: $this->config($key, $default);
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
     * Create and send mailable contact object
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Belt\Core\Http\Exceptions\ApiException
     */
    public function store(Request $request)
    {
        /**
         * @var $mailable Mailable
         * @var $pendingMail PendingMail
         */

        $this->request = $request;
        $this->template = $request->get('template') ?: 'default';

        # get / extend request class
        $requestClass = $this->config('request_class');
        if ($requestClass && is_subclass_of($requestClass, BaseRequestInterface::class)) {
            $this->request = $request = $requestClass::extend($request);
        }

        # validate
        $validator = Validator::make(
            $request->all(),
            $request->rules(),
            $request->messages()
        );

        if ($validator->fails()) {
            return response()->json($validator->messages()->messages(), 422);
        }

        # mailable
        $mailableClass = $this->config('mailable_class');
        $mailable = new $mailableClass($request->all());

        if ($from_email = $this->config('from.email')) {
            $mailable->from($from_email, $this->config('from.name'));
        }

        if ($subject = $this->get('subject')) {
            $mailable->subject($subject);
        }

        # mailer
        $pendingMail = Mail::to($this->users($this->config('to')));

        if ($cc = $this->get('cc')) {
            $pendingMail->cc($this->users($cc));
        }

        if ($bcc = $this->get('bcc')) {
            $pendingMail->bcc($this->users($bcc));
        }

        //dump($pendingMail);
        //exit;

        $pendingMail->queue($mailable);

        return response()->json([], 201);
    }

    /**
     * @param $users
     * @return array
     * @throws Belt\Core\Http\Exceptions\ApiException
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

        $this->abort(422, 'invalid users data');
    }

}
