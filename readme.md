# must important hooks and function we use in this project:

date('Ydm") // today date

## to register menus:

// function register_my_menus() {
// register_nav_menus(
// array(
// 'header-menu' => **( 'Main Menu' ),
// 'footer-menu' => **( 'Footer Menu' )
// )
// );
// }
// add_action( 'init', 'register_my_menus' );

## To get right archive url link for any post type instead of Site_url:

echo site_url('/events)

is equal:

echo get_post_type_archive_link('events')

event = could be any custom post type name

## how to use exerpt and trim word together

<?php
   if(has_excerpt()){
   * echo get_the_excerpt();
    }else{
     echo wp_trim_words( get_the_content(),14 );
    }
?>

-\* sometimes the_exerpt() make som vertical gaps between lines to remove that we can use ECHO

## custom post type has no Excerpt field we need to add it on register post type whith Supports :

register_post_type('event', array(

'supports' => array('title', 'editor', 'excerpt'),

))

## To use modern editor for our custom post type we need to activati it through register post type:

register_post_type( 'event', array(
'show_in_rest'=> true,

))

## To get your custom post types to show up in Appearance -> Menus, you need to do two things:

Check your arguments and make sure that show_in_nav_menus is set to true.

register_post_type('event', array(

'show_in_nav_menus' => true,

))

Go to the Appearance -> Menus page and at the very top, click on Screen Options.
In the panel that opens, make sure that your custom post types are checked.

# custom field plugin to ectract M,Y,D

when we define a date in custo field it gaves us a field name like event_date and we use it as follow;

<?php
$eventDate = new DateTime(get_field('event_field'));

echo $eventDate->format('M') //for month 3 char

echo $eventDate->format('d') // for day with 0

?>

# steps to add post thumbnails and featured image

on function.php add support

1- add_theme_support('post-thumbnails');

2- to show on custom post add this line to support:

'supports' => array('title', 'editor' ,'thumbnail'),

3- in right place of post we need to call it

<?php the_post_thumbnail(); ?>

4- <?php the_post_thumbnail_url() ?> // for image link on image tag

5- add image size for custom size to function.php below add supports:

add_image_size('name', heght, width, auto crop yes or no)
