<?php

namespace Base\BaseContractsDAL;
use mysqli_stmt;
use mysqli_result;

interface IDbProvider
{
    public function executeQuery(string $sql): bool|mysqli_result;
    public function executeStatement(mysqli_stmt $stmt): bool|mysqli_result;
    public function prepareStatement($sql): mysqli_stmt;
}