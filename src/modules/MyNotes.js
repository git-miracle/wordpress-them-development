import $ from 'jquery'

class MyNotes{
  constructor(){
    this.events()
  }

  events(){
    $("#my-notes").on("click" ,".delete-note", this.deleteNote)
    $("#my-notes").on("click",".edit-note" , this.editNote.bind(this))
    $("#my-notes").on("click" ,".update-note", this.updateNote.bind(this))
    $('.submit-note').on("click", this.submitNote.bind(this))

  }

  //methodes
  
  editNote(e){
    var noteId = $(e.target).parents('li');
    if(noteId.data('state') == 'editable'){
      this.makeNoteReadOnly(noteId)
    }else{
      this.makeNoteEditable(noteId)
    }
    console.log('edit mode');
  }

  makeNoteEditable(noteId) {
    noteId.find('.edit-note').html('<i class="fa fa-times"></i> Cansel');
    noteId.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
    noteId.find('.update-note').addClass('update-note--visible');
    noteId.data('state', 'editable');

  }

  makeNoteReadOnly(noteId) {
    noteId.find('.edit-note').html('<i class="fa fa-pencil"></i> Edit');
    noteId.find('.note-title-field, .note-body-field').attr('readonly', 'readonly' ).removeClass('note-active-field')
    noteId.find('.update-note').removeClass('update-note--visible');
    noteId.data('state', 'cancel');

  }

  deleteNote(e){
    var noteId = $(e.target).parents('li');
    $.ajax({
      
      beforeSend: (xhr) => {
      xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url:universityData.root_url +'/wp-json/wp/v2/note/' + noteId.data('id') ,
      type: 'DELETE' ,
      success: (response) => {
        noteId.slideUp();
        console.log('deleted');
        console.log(response);
      } ,
      error: (response) => {
        console.log('error');

        console.log(response);
      }
    })
  }
  updateNote(e){
    var noteId = $(e.target).parents('li');
    var updatedPost = {
      'title': noteId.find('.note-title-field').val(),
      'content':noteId.find('.note-body-field').val()
    }
    $.ajax({
      
      beforeSend: (xhr) => {
      xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url:universityData.root_url +'/wp-json/wp/v2/note/' + noteId.data('id') ,
      type: 'POST' ,
      data: updatedPost,
      success: (response) => {
        this.makeNoteReadOnly(noteId);
        console.log('edited');
        console.log(response);
      } ,
      error: (response) => {
        console.log('error');

        console.log(response);
      }
    })
  }
  submitNote(e){
    var creatNote = {
      'title': $('.new-note-title').val(),
      'content': $('.new-note-body').val(),
      'status': 'publish'
    }
    $.ajax({
      
      beforeSend: (xhr) => {
      xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url:universityData.root_url +'/wp-json/wp/v2/note/',
      type: 'POST' ,
      data: creatNote,
      success: (response) => {
        $('.new-note-title, .new-note-body').val('')
        $(`
        <li data-id='${response.id}'>
      <input readonly class='note-title-field' type="text" value="${response.title.raw}">
      <span class='edit-note'><i class='fa fa-pencil'></i> Edit</span>
      <span class='delete-note'><i class='fa fa-trash'> </i> Delete</span>
      <textarea readonly
        class='note-body-field'>${response.content.raw}</textarea>
      <span class='update-note btn btn--blue btn--small'><i class='<i class="fa-solid fa-floppy-disk"></i>'></i>
        Save</span>
    </li>
        `).prependTo('#my-notes').hide().slideDown()
        console.log('added');
        console.log(response);
      } ,
      error: (response) => {
        console.log('error');

        console.log(response);
      }
    })
  }
}
export default MyNotes