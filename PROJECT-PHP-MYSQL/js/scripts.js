/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



    function verifyDelete(id, formId) {
       
            var res = confirm('Vuoi eliminare il record '+id +'?');
            if(res){
               var f = document.getElementById(formId);
                  if(f){
                      document.getElementById('action').value = 'delete';
                      f.submit();
                  } else {
                      return true;
                  }
            } else {
                return false;
            }
                
    }
function previewFile(fileInput){
    var preview = document.getElementById('thumbnail');
    var file    = fileInput.files[0];
    var reader  = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

$(function () {
   $('#formLogin').submit(
       function (evt) {
        var f = evt.target;
         var email = f.email.value;
         var password = f.password.value;
         if(!email || !password){
             alert('Please, fill in email and password');
             return false;
           }
        $.ajax('verify-login.php',{
            method:'POST',
            data : {
                _csrf : f['_csrf'].value,
                email : f.email.value,
                password : f.password.value
            },
            success : function (result) {
              var res = JSON.parse(result);
               alert(res.message);
               if(res.success){
                   location.href ='index.php';
               }
            },
            error : function (error) {
                alert('Error communicating with server') 
            }
        });
       evt.preventDefault();
   }
   ); 
});