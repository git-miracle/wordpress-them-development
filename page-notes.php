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
  <div class="create-note">
    <h2 class='headline headline--medium'>Create new note</h2>
    <input type="text" class='new-note-title' placeholder='Title'>
    <textarea class='new-note-body' placeholder='Your note here...'></textarea>
    <span class='submit-note'>Create note</span>
  </div>
  <ul class='min-list link-list' id='my-notes'>
    <?php
  $userNote = new WP_Query(array(
    'post_type' => 'note',
    'post_per_page'=> -1,
    'authore'=> get_current_user_id()
  ));
  while ($userNote->have_posts()){
    $userNote->the_post(); ?>
    <li data-id='<?php the_ID() ?>'>
      <input readonly class='note-title-field' type="text"
        value="<?php echo str_replace('Private: ', '',esc_attr(get_the_title())); ?>">

      <span class='edit-note'><i class='fa fa-pencil'></i> Edit</span>
      <span class='delete-note'><i class='fa fa-trash'> </i> Delete</span>
      <textarea readonly
        class='note-body-field'><?php echo esc_attr(wp_strip_all_tags( get_the_content() )); ?></textarea>
      <span class='update-note btn btn--blue btn--small'><i class='<i class="fa-solid fa-floppy-disk"></i>'></i>
        Save</span>
    </li>
    <?php }
  ?>
  </ul>
</div>

<?php
}
get_footer();
?>