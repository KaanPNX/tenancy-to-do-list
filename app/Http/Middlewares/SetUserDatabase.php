<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Services\DatabaseConnectionService;

class SetUserDatabase
{
    protected $dbService;

    public function __construct(DatabaseConnectionService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $this->dbService->setConnection(auth()->id());
        } else {

        }

        return $next($request);
    }
}
