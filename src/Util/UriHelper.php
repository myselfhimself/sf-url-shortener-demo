<?php

namespace App\Util;

class UriHelper {

    public static function generateUniqueUri(){
        // Per https://nomadphp.com/blog/64/creating-a-url-shortener-application-in-php-mysql
        return substr(md5(uniqid(rand(), true)),0,6);
    }
}