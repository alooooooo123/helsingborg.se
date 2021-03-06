<?php

function Helsingborg_sidebar_widgets_override() {

  register_sidebar(array(
      'id' => 'footer-area',
      'name' => __('Footerarea', 'Helsingborg'),
      'description' => __('Arean längst ner', 'Helsingborg'),
      'before_widget' => '<div class="large-3 medium-12 columns %2$s"><div class="footer-content">',
      'after_widget' => '</div></div>',
      'before_title' => '<h2 class="footer-title">',
      'after_title' => '</h2>'
  ));

  register_sidebar(array(
      'id' => 'slider-area',
      'name' => __('Bildarea', 'Helsingborg'),
      'description' => __('Lägg till de sliders som ska visas på sidan.', 'Helsingborg'),
      'before_widget' => '<div class="widget large-12 columns %2$s"><div class="widget-content">',
      'after_widget' => '</div></div>'
  ));

  register_sidebar(array(
      'id' => 'content-area',
      'name' => __('Innehållsarea', 'Helsingborg'),
      'description' => __('Lägg till det som ska visas under innehållet.', 'Helsingborg'),
      'before_widget' => '<div class="widget large-12 columns %2$s"><div class="widget-content">',
      'after_widget' => '</div></div>'
  ));

  /*
  register_sidebar(array(
      'id' => 'content-area-bottom',
      'name' => __('Innehåll bottenarea', 'Helsingborg'),
      'description' => __('Lägg till det som ska visas under "Innehållsarea".', 'Helsingborg')
  ));

  register_sidebar(array(
      'id' => 'left-sidebar',
      'name' => __('Vänster area', 'Helsingborg'),
      'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
      'before_widget' => '<div class="widget large-12 medium-12 columns %2$s"><div class="widget-content">',
      'after_widget' => '</div></div>',
      'before_title' => '<h2>',
      'after_title' => '</h2>'
  ));

  register_sidebar(array(
      'id' => 'left-sidebar-bottom',
      'name' => __('Vänster bottenarea', 'Helsingborg'),
      'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
      'before_widget' => '<div class="widget large-12 medium-12 columns" %2$s><div class="widget-content">',
      'after_widget' => '</div></div>',
      'before_title' => '<h2>',
      'after_title' => '</h2>'
  ));
  */

  register_sidebar(array(
      'id' => 'right-sidebar',
      'name' => __('Höger area', 'Helsingborg'),
      'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
      'before_widget' => '<div class="widget large-12 medium-12 columns %2$s"><div class="widget-content">',
      'after_widget' => '</div></div>',
      'before_title' => '<h2>',
      'after_title' => '</h2>'
  ));

  unregister_sidebar('content-area-bottom');
  unregister_sidebar('left-sidebar');
  unregister_sidebar('left-sidebar-bottom');
}

add_action('widgets_init', 'Helsingborg_sidebar_widgets_override', 100);

?>
