<?php get_header(); ?>

<?php
while (have_posts()) {
    the_post(); 
    pageBanner (array(
      'subtitle' => 'leave subs here..'
    ));
    ?>

<div class="container container--narrow page-section">

  <div class="generic-content">

    <div class="row group">

      <div class="one-third">
        <?php the_post_thumbnail('big');  ?>
      </div>

      <div class="two-thirds">
        <?php the_content(); ?>
      </div>

    </div>

  </div>
  <hr class='section-break'>

  <?php 
    $relatedProgram = get_field('related_program');

    if($relatedProgram){
      echo '<ul>';
      echo '<h2>Subject tought:</h2>';
      
      foreach($relatedProgram AS $program) { ?>

  <li><a href="<?php echo get_the_permalink($program ) ?> "><?php echo get_the_title($program) ?></a></li>

  <?php }
        
        echo '</ul>';
  }

  ?>
</div>
<?php }
?>

</div>
<?php get_footer(); ?>