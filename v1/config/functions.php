<?php

class Functions{
    public static function getRandomToken(){
        $token = str_shuffle("AaBbCcDdFfGgHhJjKkLlMmNNOoPpQqRrSsTtUuVvWwXxYyZz11223344556677889900!.,");
        return $token;
    }
}