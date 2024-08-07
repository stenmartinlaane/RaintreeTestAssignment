<?php

use App\DAL\DbProvider;
use Base\BaseContractsDAL\IDbProvider;

return [
    IDbProvider::class => \DI\autowire(DbProvider::class),
];