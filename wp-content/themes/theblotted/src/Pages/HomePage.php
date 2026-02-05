<?php

namespace TheBlottedWP\Pages;

class HomePage
{
    public function get_page_content()
    {

        global $post;
        $page_id = $post->ID;

        $page_content = [];

        return $page_content;
    }

    /**
     * @return HomePage
     */
    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self;
        }

        return $instance;
    }
}
