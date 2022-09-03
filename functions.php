<?php
//Custom rest api here
require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');


//Create custom rest api field
function custom_rest_field(){
  register_rest_field( 'post', 'authorName', array(
    'get_callback' => function(){return get_the_author();}
  ));
  register_rest_field( 'note', 'noteCount', array(
    'get_callback' => function(){return count_user_posts( get_current_user_id(),'note' );}
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
      'root_url' => get_site_url(),
      'nonce' => wp_create_nonce( 'wp_rest' )
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

//redirect user to homepage

add_action( 'admin_init', 'redirectHome' );
function redirectHome(){
  $currentUser = wp_get_current_user();
  
  if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber'){
     wp_redirect( site_url('/') );
     exit;
  }
}

add_action( 'wp_loaded', 'noAdminBar' );
function noAdminBar(){
  $currentUser = wp_get_current_user();
  
  if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber'){
     show_admin_bar(false);
     
  }
}
//customize login screen

add_filter( 'login_headerurl', 'headerUrl' );
function headerUrl(){
  return esc_url(site_url('/' ) );
}

add_action( 'login_enqueue_scripts', 'loginCSS');

function loginCSS(){
  wp_enqueue_style('font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('reset_style', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('main_style', get_theme_file_uri('/build/style-index.css'));
}

add_filter( 'login_headertitle', 'loginTitle');

function loginTitle() {
  return get_bloginfo('name');
}

// Force note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr) {
   if($data['post_type'] == 'note') {
    if(count_user_posts(get_current_user_id(), 'note') >= 4 AND !$postarr['ID']){
      die("You have rached note limit.");
    }

    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }

  if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
    $data['post_status'] = "private";
  }
  
  return $data;
} 