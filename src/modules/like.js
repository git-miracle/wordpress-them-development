import $ from 'jquery'
class Like{
  constructor(){
    this.events();
  }
  events(){
    $('.like-box').on('click', this.clickEvent.bind(this))
  }
  //methods
  clickEvent(e){
    var likeBox = $(e.target).closest('.like-box');

    if( likeBox.attr('data-exists') == 'yes' ){
      this.deleteLike(likeBox);

    }else{
      this.addLike(likeBox)
    }

  }
  addLike(likeBox){
     $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
        },
      url:universityData.root_url + '/wp-json/university/v1/manageLike',
      type: 'POST',
      data:{
        'professorId':likeBox.data('professor')
      },
      success:(response)=>{
        likeBox.attr('data-exists', 'yes');
        var likeCount = parseInt( likeBox.find('.like-count').html() ,10);
        likeCount++;
        likeBox.find('.like-count').html(likeCount);
        likeBox.attr('data-like', response);
        console.log(response);
      },
      error: (response)=>{
        console.log(response);
      },
     })
    // alert('add likeed')
  }
  deleteLike(likeBox){
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
        },
      url:universityData.root_url + '/wp-json/university/v1/manageLike',
      data:{'like': likeBox.attr('data-like') },
      type: 'DELETE',
      success:(response)=>{
        likeBox.attr('data-exists', 'no');
        var likeCount = parseInt( likeBox.find('.like-count').html() ,10);
        likeCount--;
        likeBox.find('.like-count').html(likeCount);
        likeBox.attr('data-like', '');
        console.log(response);
      },
      error: (response)=>{
        console.log(response);
      },
     })
    // alert('delete liked')

  }
}
export default Like;