<?php namespace App\Handlers\Events;

use Log;

/**
 * Logging DB-Query
 */
class QueryLogTracker {

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * process when event 'illuminate.query' fired.
     *
     * @param  string $query    executed query.
     * @param  array  $bindings bind-parameters
     * @return void
     */
    public function handle($query, $bindings)
    {
        //
        Log::debug('EXECUTE SQL:[' . $query . ']', ['BINDINGS'=>json_encode($bindings)]);
    }

}