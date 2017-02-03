<?php namespace Ohio\Core\Http\Middleware;

use Auth, Closure, Session;
use Illuminate\Contracts\Auth\Guard;

class RequestReplacements
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    public $replacements = [];

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function replacements()
    {
        return $this->replacements ?: $this->replacements = [
            '[auth.id]' => $this->auth->id()
        ];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $replacements = $this->replacements();

        $keys = array_keys($replacements);
        $values = array_values($replacements);

        foreach ($request->route()->parameters() as $key => $value) {
            $value = str_replace($keys, $values, $value);
            $request->route()->setParameter($key, $value);
        }

        foreach ($request->query->all() as $key => $value) {
            $value = str_replace($keys, $values, $value);
            $request->query->set($key, $value);
        }

        foreach ($request->request->all() as $key => $value) {
            $value = str_replace($keys, $values, $value);
            $request->request->set($key, $value);
        }

        return $next($request);
    }

}
