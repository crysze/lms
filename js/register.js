'use strict';

const FORM = document.querySelector('form');

const $spinner = document.querySelector('.loader');

// Add an event listener to the form that is triggered by clicking the submit button

FORM.addEventListener("submit", (event) => {

  // Prevent default form submission (sending the form data to register.php)

  event.preventDefault();

  // Create an array with all of the input field IDs

  const inputIDs = ['firstname', 'lastname', 'email', 'password', 'confirm-password'];

  // Create a new empty array

  const missingInput = [];

  // Define all of the necessary HTML elements as variables

  const $responseCtn = document.querySelector('#response-ctn');
  const $responseTxt = document.querySelector('#response-txt');

  const $firstname = document.querySelector('#firstname');
  const $lastname = document.querySelector('#lastname');
  const $email = document.querySelector('#email');
  const $password = document.querySelector('#password');
  const $passwordConfirm = document.querySelector('#confirm-password');

  // Loop through all input fields and add the empty ones to the new array

  for (let index in inputIDs) {
    if (!document.getElementById(inputIDs[index]).value) {
      missingInput.push(inputIDs[index]);
    }
  }

  // Check if the new array contains empty input fields

  if (missingInput.length) {

    // Make the response disclaimer visible and add the appropriate text

    $responseCtn.style.display = 'block';
    $responseTxt.innerHTML = 'Please fill in the missing fields';

    // Highlight the missing fields with a red border

    for (let index in missingInput) {
      document.getElementById(missingInput[index]).style.border = '0.1rem solid var(--font-red)';
    }

    return;
  }

  // Validate the email address with regEx

  function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(String(email).toLowerCase());
  }

  if (!validateEmail($email.value)) {
    $responseCtn.style.display = 'block';
    $responseTxt.innerHTML = "Invalid email address";
    return;
  }

  // Check if the passwords match

  if ($password.value !== $passwordConfirm.value) {

    $responseCtn.style.display = 'block';
    $responseTxt.innerHTML = "Passwords don't match";
    return;
  }

  // Check if the passwords match

  if ($firstname.value.length > 50) {

    $responseCtn.style.display = 'block';
    $responseTxt.innerHTML = "The first name is too long (character limit: 50)";
    return;
  }

    if ($lastname.value.length > 50) {

    $responseCtn.style.display = 'block';
    $responseTxt.innerHTML = "The first name is too long (character limit: 50)";
    return;
  }

  // Send Formdata with the FormData object through XHR to register.php and display the response text

  const userFormData = new FormData(FORM);

  const XHR = new XMLHttpRequest();
  XHR.open('POST', 'ajax/register.php', true);

  // Set the header to 'XMLHttpRequest' for ajax/register.php to check if this is set to prevent direct access to the PHP file

  XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");

  XHR.onload = function() {
    if (this.status > 400) {
        $responseCtn.style.display = 'block';
        $responseTxt.innerHTML = 'There was an internal server error. Please try again later.';
        return;
    }
  }

  XHR.onreadystatechange = () => {
    if (XHR.readyState === 4 && XHR.status >= 200) {
        $spinner.style.display = 'none';
        const returnData = XHR.responseText;
        $responseCtn.style.display = 'block';
        $responseTxt.innerHTML = returnData;

        if (XHR.status === 201) {
          $responseTxt.style.background = 'white';

          // Set all input fields as readonly if the registration was successful

          for (let index in inputIDs) {
            document.getElementById(inputIDs[index]).readOnly = true;
            document.getElementById(inputIDs[index]).style.opacity = '0.5';
          }
          document.querySelector('#submit-btn-ctn').style.display = 'none';
          return;
        };


        for (let index in inputIDs) {
          document.getElementById(inputIDs[index]).readOnly = false;
          document.getElementById(inputIDs[index]).style.opacity = '1';
        }
    }
  }

  // Send the form values to register.php
  setTimeout(() => {
    XHR.send(userFormData);
  }, 3000)

  // 'Processing' should be displayed while the script is loading returnData from register.php

  for (let index in inputIDs) {
    document.getElementById(inputIDs[index]).readOnly = true;
    document.getElementById(inputIDs[index]).style.opacity = '0.5';
  }

  $spinner.style.display = 'block';
  $responseCtn.style.display = 'block';
  $responseTxt.innerHTML = 'Processing...';

});

