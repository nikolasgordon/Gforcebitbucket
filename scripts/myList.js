"use strict";

// This block will run when the DOM is loaded (once elements exist)
window.addEventListener('DOMContentLoaded', () => {
   
  //query selectors


  const addButton = document.querySelector('#addtolist');
  const picButton = document.querySelector('#addpicture');
  const shareButton = document.querySelector('#share');
  const editButton = document.querySelector('#editlist');
  const removeButton = document.querySelector('#removelist');
  const accessButton = document.querySelector('#access');
  const descriptButton = document.querySelector('#descript');

  //ADDD LIST ITEM
  const closeButton = document.querySelector("#modaladd > div > .close-button");
  const modal = document.querySelector("#modaladd");
  
  function toggleModal() {
      modal.classList.toggle("show-modal");
  }
  
  function windowOnClick(event) {
      if (event.target === modal) {
          toggleModal();
      }
  }
  
 
  closeButton.addEventListener("click", toggleModal);
  window.addEventListener("click", windowOnClick);

  //replace 'event name here' with the correct event
  addButton.addEventListener('click', event => {

    modal.classList.toggle("show-modal");
    //simply create modul, have a textbox, get th econtents of text boc and put itin the 
    //biggest downside in the shear number of php scripts needed
  });

  //ADDD PICTURE ITEM
  const closeButtonPic = document.querySelector("#modalpic > div > .close-button");
  const modalPic = document.querySelector("#modalpic");
  
  function toggleModalPic() {
      modalPic.classList.toggle("show-modal");
  }
  
  function windowOnClickPic(event) {
      if (event.target === modalPic) {
          toggleModalPic();
      }
  }
  
  closeButtonPic.addEventListener("click", toggleModalPic);
  window.addEventListener("click", windowOnClickPic);
  picButton.addEventListener('click', event => {
    //have a pic graba and send it off to a php script
    modalPic.classList.toggle("show-modal");
    
  });


///SHARE AND DESCRIPTION
const closeButtonDesp = document.querySelector("#modalDesp > div > .close-button");
  const modalDesp = document.querySelector("#modalDesp");

  function toggleModalDesp() {
    modalDesp.classList.toggle("show-modal");
}

function windowOnClickDesp(event) {
    if (event.target === modalDesp) {
        toggleModalDesp();
    }
}

closeButtonDesp.addEventListener("click", toggleModalDesp);
window.addEventListener("click", windowOnClickDesp);

  shareButton.addEventListener('click', event => {
    //list of users to share list with (a database assumbling)(might have a window to take in request)
    modalDesp.classList.toggle("show-modal");
  });




   removeButton.addEventListener('click', event => {
    //simply have an alert box which which on click remove user and their lit from database
    //transpports them to landing pae
    //cant delete list as you only have one (only did this becuase of time)
    if(confirm("do you want to remove all items in this list?")){
        //go to remove php stuff
        window.location.href = 'phpscripts/deletelist.php'
    }
    
   });


   //access  ITEM
  const closeButtonAcc = document.querySelector("#modalacc > div > .close-button");
  const modalAcc = document.querySelector("#modalacc");
  
  function toggleModalAcc() {
      modalAcc.classList.toggle("show-modal");
  }
  
  function windowOnClickAcc(event) {
      if (event.target === modalAcc) {
          toggleModalAcc();
      }
  }
  
  closeButtonAcc.addEventListener("click", toggleModalAcc);
  window.addEventListener("click", windowOnClickAcc);
  accessButton.addEventListener('click', event => {
    //get item from list to prepopulate the existing data
    //if changed, go to php script to change
    modalAcc.classList.toggle("show-modal");
    
   });

   //////////////////////ACTUAL LIST items///////////////////////////
  
    ///////////////////////////////////////////////edit////

    //const phpedit = document.querySelector('#editphp');
    descriptButton.addEventListener('click', event => {
        //get item from list to prepopulate the existing data
        //if changed, go to php script to change
        window.location.href = 'description.php';
        
       });


});