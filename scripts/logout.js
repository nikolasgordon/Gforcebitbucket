"use strict";



// This block will run when the DOM is loaded (once elements exist)
window.addEventListener('DOMContentLoaded', () => {

  
  //query selectors
  const submitButton = document.querySelector('#logout');


  //replace 'event name here' with the correct event
  submitButton.addEventListener('click', event => {

    if(confirm("are you sure you want to log out?")){
        $.ajax({
            type: "POST",
            url: 'logout.php',
            data:{action:'call_this'},
            success:function(html) {
              window.location.href = 'logout.php'
            }
 
       });
    }
     
  });
});