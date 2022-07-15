<?php

namespace Doctrine\DBAL\HyperfDB;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Driver\PDO\Result as PDOResult;
use Doctrine\DBAL\Driver\PDO\Statement as PDOStatement;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;
use Hyperf\DB\DB;

/**
 * 基于hyperf/db封装的Connection
 * 
 * @author lzpeng <liuzhanpeng@gmail.com>
 */
class Connection implements DriverConnection
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function prepare(string $sql): Statement
    {
        return new PDOStatement($this->db->prepare($sql));
    }

    public function query(string $sql): Result
    {
        /**
         * @var \PDOStatement
         */
        $statement = $this->db->prepare($sql);
        $statement->execute();

        return new PDOResult($statement);
    }

    public function quote($value, $type = ParameterType::STRING)
    {
        if (is_string($value)) {
            return $this->db->quote($value, $type);
        }

        return $value;
    }

    public function exec(string $sql): int
    {
        return $this->db->execute($sql);
    }

    public function lastInsertId($name = null)
    {
        return $this->db->lastInsertId($name);
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollBack()
    {
        return $this->db->rollBack();
    }
}
