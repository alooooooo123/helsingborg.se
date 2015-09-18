<?php

namespace Helsingborg\Theme;

class Enqueue {
    public function __construct()
    {
        add_action('wp_enqueue_scripts', '\Helsingborg\Theme\Enqueue::dequeueStyles');
        add_action('wp_enqueue_scripts', '\Helsingborg\Theme\Enqueue::enqueueStyles', 999);

        add_action('wp_enqueue_scripts', '\Helsingborg\Theme\Enqueue::dequeueScripts');
        add_action('wp_enqueue_scripts', '\Helsingborg\Theme\Enqueue::enqueueScripts');

        add_action('wp_enqueue_scripts', '\Helsingborg\Theme\Enqueue::enqueuePageStyles');
        add_action('wp_enqueue_scripts', '\Helsingborg\Theme\Enqueue::enqueuePageScripts');

        // Remove Tablepress css
        add_filter( 'tablepress_use_default_css', '__return_false' );
    }

    /**
     * Dequeues styles
     * @return void
     */
    public static function dequeueStyles()
    {

    }

    /**
     * Enqueue styles
     * @return void
     */
    public static function enqueueStyles()
    {
        wp_enqueue_style('style-app', get_template_directory_uri() . '/assets/css/dist/app.min.css');
    }

    /**
     * Dequeues scripts
     * @return void
     */
    public static function dequeueScripts()
    {
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-ui');
        //wp_dequeue_script('jquery-ui');
    }

    /**
     * Enqueue scripts
     * @return void
     */
    public static function enqueueScripts()
    {
        // Packaged jQuery
        // See the Gulpfile for scripts refereces
        wp_register_script('jquery', get_template_directory_uri() . '/assets/js/dist/jquery.min.js', array(), '1.0.0', false);
        wp_enqueue_script('jquery');

        wp_register_script('jquery-ui', get_template_directory_uri() . '/assets/js/dist/jquery-ui.min.js', array(), '1.0.0', false);

        // Readspeaker
        wp_register_script('readspeaker', 'http://f1.eu.readspeaker.com/script/5507/ReadSpeaker.js?pids=embhl', array(), '1.0.0', false);
        wp_enqueue_script('readspeaker');

        // App
        wp_register_script('app', get_template_directory_uri() . '/assets/js/dist/app.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('app');
    }

    /**
     * Enqueue page specific styles
     * @return void
     */
    public static function enqueuePageStyles()
    {

    }

    /**
     * Enqueue page specific scripts
     * @return void
     */
    public static function enqueuePageScripts()
    {
        wp_register_script('knockout', get_template_directory_uri() . '/assets/js/dist/knockout.js', array(), '3.3.0', false);

        // Search and 404
        if (is_search() || is_404()) {
            wp_register_script('app-search', get_template_directory_uri() . '/assets/js/dist/search.min.js', array(), '1.0.0', true);
            wp_enqueue_script('app-search');
        }

        // Event search
        if (is_page_template('templates/event-search.php')) {
            wp_enqueue_script('knockout');
            wp_register_script('event-list-model', get_template_directory_uri() . '/assets/js/dist/event.min.js', array(), '1.0.0', false);
            wp_enqueue_script('event-list-model');
        }

        // Alarm search
        if (is_page_template('templates/alarm-search.php')) {
            wp_enqueue_script('knockout');

            wp_register_script('alarm-list-page', get_template_directory_uri() . '/assets/js/dist/alarm.js', array(), '1.0.0', false);
            wp_enqueue_script('alarm-list-page');
        }

        // List page
        if (is_page_template('templates/list-page.php')) {
            wp_enqueue_script('knockout');
        }
    }
}