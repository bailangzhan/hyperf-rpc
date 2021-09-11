<?php

namespace App\Tools;

use App\Constants\ErrorCode;

class Result
{
    public static function success($data = [])
    {
        return static::result(ErrorCode::SUCCESS, ErrorCode::getMessage(ErrorCode::SUCCESS), $data);
    }

    public static function error($message = '', $code = ErrorCode::ERROR, $data = [])
    {
        if (empty($message)) {
            return static::result($code, ErrorCode::getMessage($code), $data);
        } else {
            return static::result($code, $message, $data);
        }
    }

    protected static function result($code, $message, $data)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }
}

