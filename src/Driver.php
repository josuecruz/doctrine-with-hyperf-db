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
        return new Connection(DB::connection($params['pool'] ?? 'default'));
    }
}
