<?php

namespace App\Tools\Result;

class Result
{
    /**
     * @param $data
     * @return array
     */
    public static function success($data = [])
    {
        return static::end(ResultCode::SUCCESS, ResultCode::getMessage(ResultCode::SUCCESS), $data);
    }

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     * @return array
     */
    public static function error($message = '', $code = ResultCode::ERROR, $data = [])
    {
        if (empty($message)) {
            return static::end($code, ResultCode::getMessage($code), $data);
        } else {
            return static::end($code, $message, $data);
        }
    }

    /**
     * @param $code
     * @param $message
     * @param $data
     * @return array
     */
    protected static function end($code, $message, $data)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }
}

