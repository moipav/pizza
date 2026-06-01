<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role->name, $roles)) {
            return $request->expectsJson()
                ? \response()->json(['message' => 'Доступ запрещен'], Response::HTTP_FORBIDDEN)
                : redirect()->back()->withErrors(['auth' => 'Недостаточно прав']);
        }

        return $next($request);
    }
}
