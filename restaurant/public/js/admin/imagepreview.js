$(document).ready(function (e) {
             
               
    $('#input_photo').change(function(){
             
     let reader = new FileReader();
  
     reader.onload = (e) => { 
  
      $('#preview-image').css('display', 'inline-block');
       $('#preview-image').attr('src', e.target.result); 
     }
  
     reader.readAsDataURL(this.files[0]); 
    
    });
    
 });