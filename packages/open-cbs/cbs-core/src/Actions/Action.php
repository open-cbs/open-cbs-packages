<?php

namespace OpenCbs\CbsCore\Actions;

use Illuminate\Support\Facades\DB;
use Throwable;

abstract class Action
{
    /**
     * Run the action within a database transaction.
     *
     * @param callable $callback
     * @param int $attempts
     * @return mixed
     * @throws Throwable
     */
    protected function transaction(callable $callback, int $attempts = 1): mixed
    {
        return DB::transaction($callback, $attempts);
    }
}
