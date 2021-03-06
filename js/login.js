'use strict';

// Get the course ID if it's been carried over to redirect the user to the course they wanted to view before logging in

const urlString = window.location.href;
const Url = new URL(urlString);
const course_id = Url.searchParams.get("id");

// Register the form

const FORM = document.querySelector('form');

// Register the spinner

const $spinner = document.querySelector('.loader');

// Add an event listener to the form that is triggered by clicking the submit button

FORM.addEventListener("submit", (event) => {

  // Prevent default form submission (sending the form data to register.php)

  event.preventDefault();

  // Create an array with all of the input field IDs

  const inputIDs = ['email', 'password'];

  // Create a new empty array

  const missingInput = [];

  const $responseCtn = document.querySelector('#response-ctn');
  const $responseTxt = document.querySelector('#response-txt');

  const $email = document.querySelector('#email');

  // Loop through all input fields and add the empty ones to a new array

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

    // Send Formdata with the FormData object through XHR to login.php and display the response text

  const userFormData = new FormData(FORM);

  const XHR = new XMLHttpRequest();
  XHR.open('POST', 'ajax/login.php', true);
  XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  XHR.onload = function() {
    if (this.status > 400 && !this.status === 403) {
        $responseCtn.style.display = 'block';
        $responseTxt.innerHTML = 'There was an internal server error.<br> Please try again later.';
        return;
    }
  }
  XHR.onreadystatechange = () => {
    if (XHR.readyState === 4 && XHR.status >= 200) {
      const returnData = XHR.responseText;
      $spinner.style.display = 'none';
      $responseCtn.style.display = 'block';
      $responseTxt.innerHTML = returnData;

      // Set all input fields as readonly if the registration was successful

      if (XHR.status === 202) {

        // Redirect the user to index.php after 3 seconds

        setTimeout(() => {
            if (course_id) {
              window.location.href = `course.php?id=${course_id}`
            } else {
              window.location.href = 'index.php';
            }
          }, 3000);
      }

      // The user should be able to re-enter his data after unsuccessful login

      if (XHR.status >= 400) {
          for (let index in inputIDs) {
            document.getElementById(inputIDs[index]).readOnly = false;
            document.getElementById(inputIDs[index]).style.opacity = '1';
          }
          document.querySelector('#submit-btn-ctn').style.display = 'flex';
      }
    }
  }

 // Send the form values to login.php
  setTimeout(() => {
    XHR.send(userFormData);
  }, 3000)


  // 'Processing' should be displayed while the script is loading returnData from login.php

  $spinner.style.display = 'block';
  $responseCtn.style.display = 'block';
  $responseTxt.innerHTML = 'Processing...';

  // After submitting data, the user shouldn't be able to edit the submission

  for (let index in inputIDs) {
    document.getElementById(inputIDs[index]).readOnly = true;
    document.getElementById(inputIDs[index]).style.opacity = '0.5';
  }
  document.querySelector('#submit-btn-ctn').style.display = 'none';

});

