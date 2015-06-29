<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 26/05/2015
 * Time: 14:21
 */

namespace app\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;

class AdminMiddleware
{
	private $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
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

		if ($this->auth->check()) {
			if ($this->auth->user()->isAdmin()) {
				return $next($request);
			}
			else {
				if ($request->ajax()) {
					return response('Unauthorized.', 401);
				}
				else {
					return redirect(route('getIndex'));
				}
			}
		}
		else {
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			}
			else {
                session(['path' => Request::path()]);
				$url = route('getLogin');
				return redirect($url);
			}
		}
	}
}