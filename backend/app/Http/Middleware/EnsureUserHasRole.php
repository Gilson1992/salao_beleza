<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnsureUserHasRole
{
    /**
     * @param  array<int, string>  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            throw new AccessDeniedHttpException('Usuário não autenticado.');
        }

        $allowedRoles = collect($roles)
            ->filter()
            ->map(fn (string $role) => Role::from($role));

        if ($allowedRoles->isEmpty()) {
            return $next($request);
        }

        if (! $allowedRoles->contains($user->role)) {
            throw new AccessDeniedHttpException('Você não possui permissão para acessar este recurso.');
        }

        return $next($request);
    }
}
