<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cache;
use App\Orm\BlockIp;
use Closure;

class BlockAccess
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
        $blockIps = Cache::get('block_ip', function() {
            $blockIps = BlockIp::all()->toArray();
            Cache::store('redis')->put('block_ip', $blockIps, 10);

            return $blockIps;
        });

        if ($blockIps) {
            foreach ($blockIps as $ip)
            {
                if (starts_with($request->getClientIp(), $ip['ip_address']))
                {
                    abort(404);
                }
            }
        }

        return $next($request);
    }

}