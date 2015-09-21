<?php

namespace App\Http\Middleware;

use App\Service\AnalysisService;
use \App\Orm\Analysis;
use Closure;

class RequestAnalysis
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
        if (!starts_with($request->getClientIp(), '192.168.0')) {
            $this->analysis();
        }

        return $next($request);
    }

    private function analysis()
    {
        $analysisService = new AnalysisService(new Analysis());
        $analysisService->pageViewIncrement();
    }
}
