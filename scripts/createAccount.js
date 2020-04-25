"use strict";

// This block will run when the DOM is loaded (once elements exist)
window.addEventListener('DOMContentLoaded', () => {

  
 // Regular expression check for email
 const emailIsValid = string => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);
  
  
  //query selectors
  const submitButton = document.querySelector('#createAccount');

  
  const emailInput = document.querySelector('#email');
  const emailError = document.querySelector('#email + span');
  
  const passSelect = document.querySelector('#pwd');
  

  const passSelect2 = document.querySelector('#pwd2');
  const passError = document.querySelector('#pwd2 + span');

  
  //replace 'event name here' with the correct event
  submitButton.addEventListener('click', event => {

    let valid = true;

    emailError.classList.add('hidden');
    passError.classList.add('hidden');

    if (emailIsValid(emailInput.value) != true){
      emailError.classList.remove('hidden');
      valid = false;
    }
    if(passSelect.value.localeCompare(passSelect2.value) != 0){
      passError.classList.remove('hidden');
      valid = false;
    }
  
    if(valid == false){
      event.preventDefault();
    }
     
  });
});