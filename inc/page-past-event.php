<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
      <p>Recap past events..</p>
    </div>
  </div>
</div>
<div class="container container--narrow page-section">
  <?php
  $today= date('Ymd');
  $pastEvent = new WP_Query(
    array(
      'paged'=> get_query_var( 'paged', 1 ),// its for paginate
      'post_type'=> 'event',
      'meta-key'=> 'event_date',
      'orderby'=> 'meta_value_num',
      'order' => 'ASC' ,//DESC
      'meta_query' =>array(
        array(
          'key'=>'event_date',
          'compare'=> '<',
          'value' => $today,
          'type'=> 'numeric'
        )
      )
    ));

  while ($pastEvent->have_posts()) {
    $pastEvent->the_post(); ?>
  <div class="event-summary">
    <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
      <span class="event-summary__month">
        <?php 
        $date = new DateTime(get_field('event_date'));
        echo $date->format('M')
      ?></span>
      <span class="event-summary__day">
        <?php 
      $date = new DateTime(get_field('event_date'));
      echo $date->format('d')
      ?></span>
    </a>
    <div class="event-summary__content">
      <h5 class="event-summary__title headline headline--tiny"><a
          href="<?php the_permalink() ?>"><?php the_title()?></a></h5>
      <p><?php echo wp_trim_words( get_the_content(), 14 ) ?><a href="<?php the_permalink() ?>" class="nu gray">Learn
          more</a></p>
    </div>
  </div>


  <?php
  }
  echo paginate_links(array(
      'total' => $pastEvent->max_num_pages
  ));
  ?>
</div>
<?php get_footer(); ?>