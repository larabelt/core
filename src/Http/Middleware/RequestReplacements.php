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

        foreach ($request->route()->parameters() as $key => $value) {
            $replacement = $this->replace($value);
            if ($replacement) {
                $request->route()->setParameter($key, $replacement);
            }
        }

        foreach ($request->query->all() as $key => $value) {
            $replacement = $this->replace($value);
            if ($replacement) {
                $request->query->set($key, $replacement);
            }

        }

        foreach ($request->request->all() as $key => $value) {
            $replacement = $this->replace($value);
            if ($replacement) {
                $request->request->set($key, $replacement);
            }
        }

        return $next($request);
    }

    public function replace($value)
    {
        if (!is_string($value)) {
            return null;
        }

        $replacements = $this->replacements();
        $keys = array_keys($replacements);
        $values = array_values($replacements);

        $replaced = str_replace($keys, $values, $value);

        if ($replaced == $value) {
            return null;
        }

        return $replaced;
    }

}
