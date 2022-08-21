<?php get_header();
pageBanner(array(
  'title'=> 'All Program',
  'subtitle'=>'We have complete program'
));
?>


<div class="container container--narrow page-section">
  <?php
  $programs= new WP_Query(array(
    'post_type'=> 'program'
  ));

  while ($programs->have_posts()) {
    $programs->the_post(); ?>
  <div class="event-summary">

    <div class="event-summary__content">
      <h2 class="event-summary__title headline "><a href="<?php the_permalink() ?>"><?php the_title()?></a></h2>
      <p><?php echo wp_trim_words( get_the_content(), 14 ) ?><a href="<?php the_permalink() ?>" class="nu gray">Learn
          more.</a></p>
    </div>
  </div>


  <?php
  }
  echo paginate_links();
  ?>

</div>
<?php get_footer(); ?>