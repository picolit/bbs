<?php

function const_value($entry, $key)
{
    $arr = \Illuminate\Support\Facades\Config::get('const.' . $entry);
    return $arr[$key];
}
