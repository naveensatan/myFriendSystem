<?php

// Declares a special exception class to identify MySQL errors
class MySQLException extends Exception
{
}

// runQuery is a utility function that throws an Exception on query failure.
// This allows cleaner error handling.
function runQuery($mysqli, $query)
{
    $res = $mysqli->query($query);
    if (!$res) {
        throw new MySQLException('Failed to run query, ' . $mysqli->errorno);
        return;
    }

    return $res;
}
