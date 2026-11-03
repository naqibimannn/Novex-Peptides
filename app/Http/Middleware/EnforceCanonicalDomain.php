<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceCanonicalDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production')) {
            $host = $request->header('host');
            $targetHost = parse_url(config('app.url'), PHP_URL_HOST);

            $isCorrectHost = ($host === $targetHost);
            $isHttps = $request->isSecure();

            if (!$isCorrectHost || !$isHttps) {
                $canonicalUrl = 'https://' . $targetHost . $request->getRequestUri();
                return redirect()->away($canonicalUrl, 301);
            }
        }

        return $next($request);
    }
}