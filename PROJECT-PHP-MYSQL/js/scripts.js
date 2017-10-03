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