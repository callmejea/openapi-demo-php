<?php

namespace util;

require_once(__DIR__ . "/../vendor/nategood/httpful/bootstrap.php");

Class Http
{
    public static function get($path, $params)
    {
        $url = self::joinParams($path, $params);
        $response = \Httpful\Request::get($url)->send();
        if ($response->hasErrors())
        {
            var_dump($response);
        }
        if ($response->body->errcode != 0)
        {
            var_dump($response->body);
        }
        return $response->body;
    }
    
    
    public static function post($path, $params, $data)
    {
        $url = self::joinParams($path, $params);
        $response = \Httpful\Request::post($url)
            ->body($data)
            ->sendsJson()
            ->send();
        if ($response->hasErrors())
        {
            var_dump($response);
        }
        if ($response->body->errcode != 0)
        {
            var_dump($response->body);
        }
        return $response->body;
    }
    
    
    private static function joinParams($path, $params)
    {
        $url = OAPI_HOST . $path;
        if (count($params) > 0)
        {
            $url = $url . "?";
            foreach ($params as $key => $value)
            {
                $url = $url . $key . "=" . $value . "&";
            }
            //in language php , count sting length use strlen or mb_strlen(for chinese), here is wrong
            $length = strlen($url);
            if ($url[$length - 1] == '&')
            {
                $url = substr($url, 0, $length - 1);
            }
        }
        return $url;
    }
}
