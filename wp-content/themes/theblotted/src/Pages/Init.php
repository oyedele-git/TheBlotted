<?php

namespace TheBlottedWP\Pages;

class Init 
{
    public static function init()
    {
        HomePage::get_instance();
    }
}