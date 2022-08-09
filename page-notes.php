<?php
if (!is_user_logged_in()){
wp_redirect(esc_url( site_url('/')));
}
get_header();

while (have_posts()) {
  the_post(); 
  pageBanner();
  ?>
<div class="container container--narrow page-section">
  <ul class='min-list link-list' id='my-notes'>
    <?php
  $userNote = new WP_Query(array(
    'post_type' => 'note',
    'post_per_page'=> -1,
    'authore'=> get_current_user_id()
  ));
  while ($userNote->have_posts()){
    $userNote->the_post(); ?>
    <li>
      <input class='note-title-field' type="text" value="<?php echo esc_attr(get_the_title()); ?>">
      <span class='edit-note'><i class='fa fa-pencil'></i></span>
      <span class='delete-note'><i class='fa fa-trash'></i></span>
      <textarea class='note-body-field'><?php echo esc_attr(wp_strip_all_tags( get_the_content() )); ?></textarea>
    </li>
    <?php }
  ?>
  </ul>
</div>

<?php


}
get_footer();
?>