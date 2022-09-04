<?php
add_action('rest_api_init', 'likeRoute');

function likeRoute(){
  register_rest_route('university/v1','manageLike',array(
    'methods'=> 'POST',
    'callback' =>'addLike'
  ) );

  register_rest_route('university/v1','manageLike',array(
    'methods'=> 'DELETE',
    'callback' =>'deleteLike'
  ) );
}

function addLike($data){

  if(is_user_logged_in()) {
    $professor = sanitize_text_field($data['professorId']);
    $existQuery = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type'=>'like',
      'meta_query' => array(
        array(
          'key' => 'like_id',
          'compare' => '=',
          'value'=> $professor
        )
      )
        ));

    if($existQuery->found_posts == 0 AND get_post_Type($professor) == 'professor'){
      return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title'=> 'create text 2nd',
        'meta_input' => array(
          'like_id' => $professor
        )
        ));
    }else{
      die('Invalid professor ID');
    }
  
  }else{
    die('only logged in user can like');
  }
 }

function deleteLike($data){
$likeId = sanitize_text_field($data['like'] );
if (get_current_user_id() == get_post_field('post_author',$likeId) AND get_post_type($likeId) == 'like') {
  wp_delete_post($likeId, true);
  return 'like removed.';
}else{
  die('you don not have  permisson to delet');
}
}