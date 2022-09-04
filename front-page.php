<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php 
    $image = get_field('home_hero_image');
    echo $image['sizes']['hero'];
    ?>)"></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large"><?php echo get_field('home_title') ?></h1>
    <h2 class="headline headline--medium"><?php echo get_field('home_sub1') ?></h2>
    <h3 class="headline headline--small"><?php echo get_field('home_sub2') ?></h3>
    <a href="<?php echo get_field('home_botton_link') ?>"
      class="btn btn--large btn--blue"><?php echo get_field('home_botton') ?></a>
  </div>
</div>

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
      <?php 
        $today= date('Ymd');
        $eventHome = new WP_Query(
          array(
            'posts_per_page'=> 2,// -1 for all existing
            'post_type'=> 'event',
            'meta-key'=> 'event_date',// To sort for upcoming event
            'orderby'=> 'meta_value_num',// it could be "title" or other fields
            'order' => 'ASC' ,//DESC
            'meta_query' =>array(
              array(
                'key'=>'event_date',
                'compare'=> '>=',
                'value' => $today,
                'type'=> 'numeric'
              )
            )

          ));
          
        while($eventHome->have_posts()){
          $eventHome->the_post()?>

      <div class="event-summary">
        <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
          <span class="event-summary__month">
            <?php 
            $date= new DateTime(get_field('event_date'));
            echo $date->format('M');
            ?>

          </span>
          <span class="event-summary__day"><?php echo $date->format('d')?></span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a
              href="<?php the_permalink() ?>"><?php the_title()?></a></h5>
          <p><?php if(has_excerpt()){
             echo get_the_excerpt();
          }else{
            echo wp_trim_words( get_the_content(),14 );
          }?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
        </div>
      </div>

      <?php }
?>
      <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link( 'event' ) ?>"
          class="btn btn--blue">View All
          Events</a></p>
    </div>
  </div>
  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
      <?php
          $postHome = new WP_Query(array(
            'posts_per_page' => 2,
          ));
          while($postHome->have_posts()){
            $postHome->the_post();?>
      <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink() ?>">
          <span class="event-summary__month"><?php the_time('M') ?></span>
          <span class="event-summary__day"><?php the_time('d') ?></span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a
              href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
          <p><?php if(has_excerpt()){
             echo get_the_excerpt();
          }else{
            echo wp_trim_words( get_the_content(),14 );
          }?> <a href="<?php the_permalink() ?>" class="nu gray">Read
              more</a></p>
        </div>
      </div>
      <?php
          }
          wp_reset_postdata( );
          ?>
      <p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">View All Blog
          Posts</a>
      </p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <?php
          $slideHome = new WP_Query(array(
            'post_type' => 'slide', 
            'posts_per_page' => 3,
          ));
          while($slideHome->have_posts()){
            $slideHome->the_post();?>

      <div class="hero-slider__slide" style="background-image: url(<?php 
         $image = get_field('slide_image');
         echo $image['sizes']['slide'];
        ?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center"><?php echo get_field('slide_title'); ?></h2>
            <p class="t-center"><?php echo get_field('slide_subtitle'); ?></p>
            <p class="t-center no-margin"><a href="<?php echo get_field('botton_link'); ?>"
                class="btn btn--blue"><?php echo get_field('slide_botton'); ?></a>
            </p>
          </div>

        </div>
      </div>
      <?php } ?>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>

<?php get_footer(); ?>