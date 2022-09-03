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
        <?php
        $like = new WP_Query(array(
          'post_type'=>'like',
          'meta_query' => array(
            array(
              'key' => 'like_id',
              'compare' => '=',
              'value'=>get_the_ID()
            )
          
          )
            ));

        $existLike = 'no'; 
        if (is_user_logged_in()) {
          $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type'=>'like',
            'meta_query' => array(
              array(
                'key' => 'like_id',
                'compare' => '=',
                'value'=>get_the_ID()
              )
            
            )
              ));
              
              if($existQuery->found_posts){
                $existLike = 'yes';
              }
        }  
        
        ?>
        <span class="like-box" data-like='<?php echo $existQuery->posts[0]->ID; ?>' data-professor='<?php the_ID(); ?>'
          data-exists='<?php echo $existLike; ?>'>
          <i class="fa fa-heart-o"></i>
          <i class="fa fa-heart"></i>
          <span class="like-count"><?php echo $like->found_posts ?></span>
        </span>
        <?php the_content(); ?>
      </div>

    </div>

  </div>
  <hr class='section-break'>

  <?php 
    $relatedProgram = get_field('related_program');

    if($relatedProgram){
      echo '<ul>';
      echo '<h2>Subject by this teacher:</h2>';
      
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