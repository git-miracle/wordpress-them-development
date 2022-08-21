<?php get_header(); ?>

<?php
while (have_posts()) {
    the_post();  ?>
<div class="page-banner">
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php the_title() ?></h1>
    <div class="page-banner__intro">
      <p>Reolace me latter dont forget it Farhad</p>
    </div>
  </div>
</div>
<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'program' ) ?>"><i
          class="fa fa-home" aria-hidden="true"></i> All programs home</a> <span
        class="metabox__main"><?php the_title() ?></span>
    </p>
  </div>
  <div class="generic-content"><?php the_content(); ?></div>



  <?php 

  $professor = new WP_Query(
  array(
    'posts_per_page'=> 2,// -1 for all existing
    'post_type'=> 'professor',
    'orderby'=> 'title',// it could be "title" or other fields
    'order' => 'ASC' ,//DESC
    'meta_query' =>array(
      
      array(
        'key' => 'related_program',
        'compare' => 'LIKE', //LIKE means here contain
        'value' => '"' . get_the_ID() . '"'
       )
    )

  ));
?>
  <?php if($professor->have_posts()){ ?>
  <hr class="section-break">
  <h2>Professor toughts <?php  the_title()?> :</h2>

  <ul class="professor-cards">

    <?php

 while($professor->have_posts()){
              $professor->the_post()?>

    <li class='professor-card__list-item'>
      <a class='professor-card' href="<?php the_permalink() ?>">
        <img class='professor-card_image' src="<?php the_post_thumbnail_url('big') ?>" alt="">
        <span class='professor-card_name'><?php the_title( ) ?></span>
      </a>
    </li>

    <?php }
  echo '</ul>';

  wp_reset_postdata(  );// after WP_Query we need to you this to reset data
    ?>

    <?php
}

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
                'type'=> 'numeric',
              ),
              array(
                'key' => 'related_program',
                'compare' => 'LIKE', //LIKE means here contain
                'value' => '"' . get_the_ID() . '"'
               )
            )

          ));
  ?>
    <?php if($eventHome->have_posts()){ ?>
    <hr class="section-break">
    <h2>Event(s) related to <?php  the_title()?> :</h2>
    <?php
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
    <?php
  }
  ?>
</div>
<?php }
?>


</div>
<?php get_footer(); ?>