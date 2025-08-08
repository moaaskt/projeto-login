<?php

if (!function_exists('printArray')) {
    function printArray($d)
    {
        echo '<pre>';
        print_r($d);
        echo '</pre>';
        exit;
    }
}

if (!function_exists('printj')) {
    function printj($d)
    {
        header('Content-Type: application/json');
        try {
            echo json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
        exit;
    }
}

if (!function_exists('varj')) {
    function varj($d)
    {
        var_dump($d);
        exit;
    }
}
