<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 31/05/2015
 * Time: 17:42
 */

namespace app\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class DbLogging
{
    protected $dbLogStoragePath;

    public function __construct()
    {
        $this->dbLogStoragePath = storage_path('logs/query.log');
    }

    private function logDb()
    {
        if ((boolean)$_ENV['APP_DEBUG'] === true) {
            DB::listen(function ($sql, $bindings, $time) {
                $monolog = new Logger('log');
                $monolog->pushHandler(new StreamHandler($this->dbLogStoragePath), Logger::INFO);
                $monolog->info($sql, compact('bindings', 'time'));

            });
        }

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
        $this->logDb();

        return $next($request);
    }
}