<?php

namespace Doctrine\DBAL\HyperfDB;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Hyperf\Context\Context;
use Hyperf\DB\DB;

class Driver extends AbstractMySQLDriver
{
    /**
     * @inheritDoc
     */
    public function connect(array $params)
    {
        $contextKey = 'doctrine.connection';
        $hasContextConnection = Context::has($contextKey);
        if ($hasContextConnection) {
            return Context::get($contextKey);
        }

        $connection = new Connection(DB::connection($params['pool'] ?? 'default'));
        Context::set($contextKey, $connection);

        return new Connection(DB::connection($params['pool'] ?? 'default'));
    }
}
