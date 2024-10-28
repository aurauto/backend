<?php

class Api
{
    private static $instance = null;
    private $base_url = null;

    private function __construct()
    {
        $this->base_url = getenv('API_URL');
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Api();
        }
        return self::$instance;
    }

    public function getBrand()
    {

    }
}

?>