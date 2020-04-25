"use strict";

// This block will run when the DOM is loaded (once elements exist)
window.addEventListener('DOMContentLoaded', () => {

  //query selectors
  const updateButton = document.querySelector('#updateuser');
  const updateEmail = document.querySelector('#updateemail');
  const updatePassword = document.querySelector('#updatepassword');
  const editListButton = document.querySelector('#editlist');  
  const removeAccount = document.querySelector('#removeaccount')

  //update account ITEM
  const closeButtonUpdate = document.querySelector("#modalupdate > div > .close-button");
  const modalUpdate = document.querySelector("#modalupdate");
  
  function toggleModalUpdate() {
      modalUpdate.classList.toggle("show-modal");
  }
  
  function windowOnClickUpdate(event) {
      if (event.target === modalUpdate) {
          toggleModalUpdate();
      }
  }
  
  closeButtonUpdate.addEventListener("click", toggleModalUpdate);
  window.addEventListener("click", windowOnClickUpdate);

  //replace 'event name here' with the correct event
  updateButton.addEventListener('click', event => {

    modalUpdate.classList.toggle("show-modal");
    //simply create modul, have a textbox, get th econtents of text boc and put itin the 
    //biggest downside in the shear number of php scripts needed
  });



   //update account ITEM
   const closeButtonEmail = document.querySelector("#modalemail > div > .close-button");
   const modalEmail = document.querySelector("#modalemail");
   
   function toggleModalEmail() {
       modalEmail.classList.toggle("show-modal");
   }
   
   function windowOnClickEmail(event) {
       if (event.target === modalEmail) {
           toggleModalEmail();
       }
   }
   
   closeButtonEmail.addEventListener("click", toggleModalEmail);
   window.addEventListener("click", windowOnClickEmail);
 
   //replace 'event name here' with the correct event
   updateEmail.addEventListener('click', event => {
 
     modalEmail.classList.toggle("show-modal");
     //simply create modul, have a textbox, get th econtents of text boc and put itin the 
     //biggest downside in the shear number of php scripts needed
   });



   //update account ITEM
   const closeButtonPass = document.querySelector("#modalpassword > div > .close-button");
   const modalPass = document.querySelector("#modalpassword");
   
   function toggleModalPass() {
       modalPass.classList.toggle("show-modal");
   }
   
   function windowOnClickPass(event) {
       if (event.target === modalPass) {
           toggleModalPass();
       }
   }
   
   closeButtonPass.addEventListener("click", toggleModalPass);
   window.addEventListener("click", windowOnClickPass);
 
   //replace 'event name here' with the correct event
   updatePassword.addEventListener('click', event => {
 
     modalPass.classList.toggle("show-modal");
     //simply create modul, have a textbox, get th econtents of text boc and put itin the 
     //biggest downside in the shear number of php scripts needed
   });

   editListButton.addEventListener('click', event => {
    //get header and go to your list edit page
    window.location.href = 'myList.php';
   });

   removeAccount.addEventListener('click', event => {
    //simply have an alert box which which on click remove user and their lit from database
    //transpports them to landing pae
    //cant delete list as you only have one (only did this becuase of time)
    if(confirm("Do you really want to remove this account")){
        //go to remove php stuff
        window.location.href = 'phpscripts/delete.php'
        //(<?php echo $_SESSION['id'] ?>);
    }
    
   });

   /////////////////////////////////////////////////MODAL ERROR CHECKING/////////////////////////////////
   //not in order I know but it helps me keep track of things

   const emailIsValid = string => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);

   const submitUser = document.querySelector('#usersubmit');
   const submitEmail = document.querySelector('#emailsubmit');
   const submitPass = document.querySelector('#passsubmit');
  
   const userSelect = document.querySelector('#usernamechange');
   const userSelect2 = document.querySelector('#usernamechange2');
   const userError = document.querySelector('#usernamechange2 + span');
   
   const emailSelect = document.querySelector('#emailchange');
   const emailError2 = document.querySelector('#emailchange + span');
   const emailSelect2 = document.querySelector('#emailchange2');
   const emailError = document.querySelector('#emailchange2 + span');
  
   const passSelect = document.querySelector('#passchange');
   const passSelect2 = document.querySelector('#passchange2');
   const passError = document.querySelector('#passchange2 + span');

   submitUser.addEventListener('click', event => {

    let valid = true;

    
    userError.classList.add('hidden');
    
    if(userSelect.value.localeCompare(userSelect2.value) != 0){
        userError.classList.remove('hidden');
        valid = false;
      }
  
    if(valid == false){
      event.preventDefault();
    }
     
  });

  submitEmail.addEventListener('click', event => {

    let valid = true;

    emailError.classList.add('hidden');
    
    if (emailIsValid(emailSelect.value) != true){
      emailError2.classList.remove('hidden');
      valid = false;
    }
    
    if(emailSelect.value.localeCompare(emailSelect2.value) != 0){
        emailError.classList.remove('hidden');
        valid = false;
      }
  
    if(valid == false){
      event.preventDefault();
    }
     
  });

  submitPass.addEventListener('click', event => {

    let valid = true;

    //jquery stuff
    
    
    //

    passError.classList.add('hidden');
    
    if(passSelect.value.localeCompare(passSelect2.value) != 0){
        passError.classList.remove('hidden');
        valid = false;
      }
  
    if(valid == false){
      event.preventDefault();
    }
     
  });


   

});