<?php
/**
 * Created by PhpStorm.
 * User: mrussell
 * Date: 11/3/14
 * Time: 1:45 AM
 */

namespace HttpMethods;


class HttpMethod extends \UNBOXAPI\Module{

    protected static $_name = "HttpMethods";
    protected static $_type = "Module";
    protected static $_enabled = true;

    protected static $_available_methods = array(
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
        'TRACE',
        'HEAD',
        'OPTIONS'
    );
    public static function get(){
        $methods = array();
        $count=1;
        foreach(static::$_available_methods as $method){
            $methods[] = array(
                'id' => $count,
                'method' => $method
            );
            $count++;
        }
        return $methods;
    }
} 