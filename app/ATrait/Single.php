<?php

namespace app\ATrait;


trait Single
{

    private static $instance;

    public static function getInstance()
    {
        if (!(self::$instance && (self::$instance instanceof self))) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}
