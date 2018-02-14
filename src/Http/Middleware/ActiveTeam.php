<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure;
use Belt\Core\Services\ActiveTeamService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

/**
 * Class ActiveTeam
 * @package Belt\Core\Http\Middleware
 */
class ActiveTeam
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var ActiveTeamService
     */
    public $service;

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
     * @param Request $request
     * @return ActiveTeamService
     */
    public function service(Request $request = null)
    {
        $service = $this->service ?: $this->service = new ActiveTeamService([
            'user' => $this->auth->user(),
        ]);

        $service->request = $request ?: $service->request;

        return $service;
    }

    /**
     * Handle an incoming request re: active team
     *
     * - allow url query parameter to set/override active team
     * - persist active team in session
     * - unset team setting with url query parameter value of 0
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dump(111);
//        dump(request()->fullUrlWithQuery(['active_team_id' => 123]));
//        exit;
        $service = $this->service($request);

        if ($request->query->has('team_id') && !$request->query->get('team_id')) {
            $service->forgetTeam();
        }

        $active_team_id = $service->getActiveTeamId() ?: $service->getDefaultTeamId();

        $service->forgetTeam();

        if ($active_team_id) {
            if (!$service->isAuthorized($active_team_id)) {
                abort(403);
            }
            $service->setTeam($active_team_id);
        }

        return $next($request);
    }

}