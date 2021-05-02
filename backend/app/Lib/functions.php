<?php

/**
 * 构造JSON响应体
 *
 * @param mixed $data
 * @param integer $code
 * @param string $msg
 * @return array
 */
function res_data($data = null, int $code = 0, string $msg = "")
{
    $res = [
        "data" => $data,
        "code" => $code,
        "msg" => $msg
    ];
    return $res;
}