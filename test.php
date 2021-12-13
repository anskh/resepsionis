<?php

declare(strict_types=1);

if (!defined("ROOT")) define("ROOT", __DIR__);

require_once ROOT . "/vendor/autoload.php";

app()->init(__DIR__ . '/config');


function Search($search, $string)
{
    $position = strpos($string, $search, 5);
    if (is_numeric($position)) {
        return "Found at position: " . $position;
    } else {
        return "Not Found";
    }
}

// Driver Code
$string = "/Welcome to {id:\d+}GeeksforGeeks";
echo $string . PHP_EOL;
$search = "{";
echo Search($search, $string) . PHP_EOL;

$string = "admin guest{id";
echo $string . PHP_EOL;
echo Search($search, $string) . PHP_EOL;
