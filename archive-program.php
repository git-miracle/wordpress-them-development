<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">All Program</h1>
    <div class="page-banner__intro">
      <p>we have complete program </p>
    </div>
  </div>
</div>
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