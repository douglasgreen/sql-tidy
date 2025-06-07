#!/usr/bin/env php
<?php

declare(strict_types=1);

use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Components\Expression;
use PhpMyAdmin\SqlParser\Context;

require __DIR__ . '/vendor/autoload.php';

$query1 = 'select * from a';
$parser = new Parser($query1);

// inspect query
var_dump($parser->statements[0]); // outputs object(PhpMyAdmin\SqlParser\Statements\SelectStatement)

// modify query by replacing table a with table b
$table2 = new Expression('', 'b', '', '');

// @phpstan-ignore-next-line
$parser->statements[0]->from[0] = $table2;

// build query again from an array of object(PhpMyAdmin\SqlParser\Statements\SelectStatement) to a string
$statement = $parser->statements[0];
$query2 = $statement->build();
var_dump($query2); // outputs string(19) 'SELECT  * FROM `b` '

// Change SQL mode
Context::setMode(Context::SQL_MODE_ANSI_QUOTES);

// build the query again using different quotes
$query2 = $statement->build();
var_dump($query2); // outputs string(19) 'SELECT  * FROM "b" '
