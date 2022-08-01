<?php get_header(); ?>

<?php
while (have_posts()) {
    the_post(); 
    pageBanner();
    ?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo site_url('/events') ?>"><i class="fa fa-home"
          aria-hidden="true"></i> Event home</a> <span class="metabox__main"><?php the_title() ?></span>
    </p>
  </div>
  <div class="generic-content"><?php the_content(); ?></div>
  <hr class='section-break'>

  <?php 
    $relatedProgram = get_field('related_program');

    if($relatedProgram){
      echo '<ul>';
      echo '<p>Related program(s):';
      
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