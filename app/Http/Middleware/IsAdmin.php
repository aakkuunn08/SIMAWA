public function handle($request, Closure $next)
{
    if (!auth()->check() || auth()->user()->is_admin !== 1) {
        abort(403, 'Access denied');
    }

    return $next($request);
}
