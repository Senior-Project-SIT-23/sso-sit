<?php

function generateCode($length = 5)
{
    $code = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, $length);
    return $code;
}

function getOriginHost($request)
{
    return $request->headers->get('origin');
}
