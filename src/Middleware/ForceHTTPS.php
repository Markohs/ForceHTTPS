<?php

namespace Markohs\ForceHTTPS\Middleware;

use App;
use Closure;

class ForceHTTPS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->secure() && App::environment(config('forcehttps.envs_enabled')) && ! $this->isWhitelisted($request)) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }

    private function isWhitelisted($request)
    {
        if (config('forcehttps.whitelist_url') == null) {
            return false;
        }

        $regex = '#'.implode('|', config('forcehttps.whitelist_url')).'#';

        return preg_match($regex, $request->path());
    }
}
