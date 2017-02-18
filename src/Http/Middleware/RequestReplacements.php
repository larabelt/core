<?php namespace Belt\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class RequestReplacements
 * @package Belt\Core\Http\Middleware
 */
class RequestReplacements
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @var array
     */
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

    /**
     * @return array
     */
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

    /**
     * @param $value
     * @return mixed|null
     */
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
