<?php

//下划线命名到驼峰命名
function toCamelCase($str)
{
    $array = explode('_', $str);
    $result = '';
    $len = count($array);

    for ($i = 0; $i < $len; $i++) {
        $result .= ucfirst($array[$i]);
    }

    return $result;
}
