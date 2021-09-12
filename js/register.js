'use strict';

const FORM = document.querySelector('form');

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
      document.getElementById(missingInput[index]).style.border = '0.3rem solid var(--font-red)';
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

    // Send Formdata with the FormData object through XHR to register.php and display the response text

    const userFormData = new FormData(FORM);

    const XHR = new XMLHttpRequest();
    XHR.open('POST', 'register.php', true);
    XHR.onreadystatechange = () => {
      if (XHR.readyState === 4 && XHR.status === 200) {
          const returnData = XHR.responseText;
          $responseCtn.style.display = 'block';
          $responseTxt.innerHTML = returnData;

        // Set all input fields as readonly if the registration was successful

        if (document.querySelector('#login-link')) {
          for (let index in inputIDs) {
            document.getElementById(inputIDs[index]).readOnly = true;
            document.getElementById(inputIDs[index]).style.opacity = '0.5';
          }
          document.querySelector('#submit-btn-ctn').style.display = 'none';
        }
      }
    }

    // Send the form values to register.php

    XHR.send(userFormData);

    // 'Processing' should be displayed while the script is loading returnData from register.php

    $responseCtn.style.display = 'block';
    $responseTxt.innerHTML = 'Processing...';

});

