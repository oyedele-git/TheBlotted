<?php 

namespace TheBlottedWP\Core;

class AdminCustomizer {

    public function __construct() {
        add_action( 'customize_register', [$this, 'register']);
        // add_action( 'customize_preview_init', [$this, 'theblotted_theme_customize_preview_js']);

    }

    public function register( $wp_customize ) {
        $wp_customize->get_setting( 'blogname' )->transport             = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport      = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport     = 'postMessage';

        if ( isset ( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial(
                'blogname',
                array(
                    'selector'          => '.site-title a',
                    'render_callback'   => [$this, 'theblotted_theme_customize_partial_blogname'],
                )
            );
            $wp_customize->selective_refresh->add_partial(
                'blogdescription',
                array(
                    'selector'          => '.site-description',
                    'render_callback'   => [$this, 'theblotted_theme_customize_partial_blogdesription'],
                )
            );
        }

        // Main Panel
        $wp_customize->add_panel( 'theblotted', [
            'title'         => __('The Blotted Settings', 'theblotted'),
            'description'   =>  '<p> The Blotted Theme Settings </p>',
            'priority'      =>  10
        ]);

        // Newsletter Section
        $wp_customize->add_section( 'the-blotted-newsletter-section' , array(
            'title'         => __('Newsletter', 'theblotted' ),
            'priority'      => 20,
            'panel'         => 'theblotted'
        ));
        
        // Newsletter Setting/Controls
        $wp_customize->add_setting(' the-blotted-newsletter-setting',
            [
                'default'   => ''
            ]);
        $wp_customize->add_control( new \WP_Customize_Control($wp_customize, 'the-blotted-newsletter-heading-control',
            array(
                'label'     => 'Newsletter Banner Heading',
                'section'   => 'the-blotted-newsletter-section',
                'settings'  => 'the-blotted-newsletter-setting',
                'type'      => 'text'
            )
        ));

        $wp_customize->add_setting(' the-blotted-mailchimp-setting',
            [
                'default'   => ''
            ]);
        $wp_customize->add_control( new \WP_Customize_Control($wp_customize, 'the-blotted-mailchimp-setting',
            array(
                'label'     => 'Mailchimp Shortcode',
                'section'   => 'the-blotted-newsletter-section',
                'settings'  => 'the-blotted-mailchimp-setting',
                'type'      => 'text'
            )
        ));

        // Social Handles Section
        $wp_customize->add_section( 'the-blotted-social-section', array(
            'title'         => __( 'Social Handles', 'theblotted' ),
            'priority'      => 30,
            'panel'         => 'theblotted'
        ));

        // Social Handles Settings/Controls
        $wp_customize->add_setting( 'the-blotted-instagram-setting',
            [
                'default'   => ''
            ]);
        $wp_customize->add_control( new \WP_Customize_Control($wp_customize, 'the-blotted-instagram-control',
            array(
                'label'     =>  'Instagram URL',
                'section'   =>  'the-blotted-social-section',
                'settings'  =>  'the-blotted-instagram-setting',
                'type'      =>  'url'
            )
        ));

        $wp_customize->add_setting( 'the-blotted-facebook-setting',
        [
            'default'   => ''
        ]);
        $wp_customize->add_control( new \WP_Customize_Control($wp_customize, 'the-blotted-facebook-control',
            array(
                'label'     =>  'Facebook URL',
                'section'   =>  'the-blotted-social-section',
                'settings'  =>  'the-blotted-facebook-setting',
                'type'      =>  'url'
            )
        ));

        $wp_customize->add_setting( 'the-blotted-threads-setting',
        [
            'default'   => ''
        ]);
        $wp_customize->add_control( new \WP_Customize_Control($wp_customize, 'the-blotted-threads-control',
            array(
                'label'     =>  'Threads URL',
                'section'   =>  'the-blotted-social-section',
                'settings'  =>  'the-blotted-threads-setting',
                'type'      =>  'url'
            )
        ));

        $wp_customize->add_setting( 'the-blotted-twitter-setting',
        [
            'default'   => ''
        ]);
        $wp_customize->add_control( new \WP_Customize_Control($wp_customize, 'the-blotted-twitter-control',
            array(
                'label'     =>  'Twitter URL',
                'section'   =>  'the-blotted-social-section',
                'settings'  =>  'the-blotted-twitter-setting',
                'type'      =>  'url'
            )
        ));
    }

    public function the_blotted_wp_theme_customize_partial_blogname() {
        bloginfo( 'name' );
    }

    public function the_blotted_wp_theme_customize_partial_blogdescription() {
        bloginfo( 'description' );
    }

    public function the_blotted_wp_theme_customize_preview_js() {
        wp_enqueue_script( 'theblotted-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), THEBLOTTED_VERSION, true );
    }

    /**
     * Singleton poop
     * 
     * @return AdminCustomizer|null
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
    
}