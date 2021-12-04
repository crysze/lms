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
  XHR.open('POST', 'login.php', true);
  XHR.onreadystatechange = () => {
    if (XHR.readyState === 4 && XHR.status >= 200) {
      console.log(XHR.status);
      const returnData = XHR.responseText;
      $responseCtn.style.display = 'block';
      $responseTxt.innerHTML = returnData;

      // Set all input fields as readonly if the registration was successful

      if ($responseTxt.innerHTML === "You've logged in successfully. Redirecting...") {

        $spinner.style.visibility = 'visible';

        for (let index in inputIDs) {
          document.getElementById(inputIDs[index]).readOnly = true;
          document.getElementById(inputIDs[index]).style.opacity = '0.5';
        }
        document.querySelector('#submit-btn-ctn').style.display = 'none';

        // Redirect the user to index.php after 3 seconds

        setTimeout(() => {
            course_id ? window.location.href = `course.php?id=${course_id}` : window.location.href = 'index.php';
          }, 3000);
      }
    }
  }

  // Send the form values to login.php

  XHR.send(userFormData);

  // 'Processing' should be displayed while the script is loading returnData from login.php

  $responseCtn.style.display = 'block';
  $responseTxt.innerHTML = 'Processing...';
});

