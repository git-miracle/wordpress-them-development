<?php

//Create custom rest api field
function custom_rest_field(){
  register_rest_field( 'post', 'authorName', array(
    'get_callback' => function(){return the_author();}
  ));
}
add_action( 'rest_api_init', 'custom_rest_field');
//end of Create custom rest api field


function pageBanner($args = NULL) {

  if(!$args['title']){
    $args['title'] = get_the_title();
  }

  if (!$args['subtitle']){
   
    $args['subtitle']= get_field('page_banner_subtitle');
  
}

  if(!$args['photo']){
    if(get_field('page_banner_backgrnd')  AND !is_archive() AND !is_home() ){
    $args['photo'] = get_field('page_banner_backgrnd')['sizes']['banner'];
  }else{
    $args['photo']= get_theme_file_uri( '/images/ocean.jpg' );
  }
}

    ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php 
    echo $args['photo'];
     ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
    <div class="page-banner__intro">
      <p><?php  echo $args['subtitle']; ?></p>
    </div>
  </div>
</div>

<?php }


function load_styles()
{

    wp_enqueue_script('main_js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('reset_style', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('main_style', get_theme_file_uri('/build/style-index.css'));

    wp_localize_script('main_js', 'universityData', array(
      'root_url' => get_site_url()
    ));
  
}
add_action('wp_enqueue_scripts', 'load_styles');



function site_features()
{

    // register_nav_menu( 'header-menu', __('Header Menu') );
    // register_nav_menu( 'footer-menu', __('Footer Menu') );
    // register_nav_menu( 'footer-menu-two', __('Footer Menu two') );

    add_theme_support('title-tag');
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'portrait', 480 ,650 , true  );
    add_image_size( 'big',  300, 600 , true);
    add_image_size( 'banner', 1500, 350, true );

    register_nav_menus(array(
        'header-menu' => 'Header Menu',
        'footer-menu' => 'Footer Menu',
        'footer-menu-two' => 'Footer Menu two'
    ));
}
add_action('after_setup_theme', 'site_features');


function adjust_query($query){
  // program quey
  if (!is_admin() AND is_post_type_archive('program') And $query->is_main_query()){

      $query->set('orderby', 'title');
       $query->set('order' , 'ASC');
  }
  // event query
   if (!is_admin() AND is_post_type_archive('event') And $query->is_main_query()){

       $today= date('Ymd'); 
       $query->set('meta-key', 'event_date');
       $query->set('orderby', 'meta_value_num');
       $query->set('order' , 'ASC');
       $query->set('meta_query' ,array(
        array(
          'key'=>'event_date',
          'compare'=> '>',
          'value' => $today,
          'type'=> 'numeric'
        )
      ));
}
}
add_action( 'pre_get_posts', 'adjust_query' );