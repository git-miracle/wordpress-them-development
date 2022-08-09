import $ from 'jquery'

class MyNotes{
  constructor(){
    this.events()
  }

  events(){
    $(".delete-note").on("click" , this.deleteNote)

  }

  //methodes
  deleteNote(){
    alert('hooooooooooo')
  }
}
export default MyNotes