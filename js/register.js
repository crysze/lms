'use strict';

const FORM = document.querySelector('form');

// Add an event listener to the form that is triggered by form submission

FORM.addEventListener("submit", (event) => {

  // Create an array with all of the input field IDs

  const inputIDs = ['firstname', 'lastname', 'email', 'password', 'confirm-password'];

  const missingInput = [];

  const $missingFieldsCtn = document.querySelector('#missing-fields-ctn');
  const $passwordWrongCtn = document.querySelector('#password-wrong-ctn');

  const $mandatoryFields = document.querySelector('#mandatory-fields');
  const $password = document.querySelector('#password');
  const $passwordConfirm = document.querySelector('#confirm-password');

  // Loop through all input fields and add the empty ones to a new array

  for (let index in inputIDs) {
    if (!document.getElementById(inputIDs[index]).value) {
      missingInput.push(inputIDs[index]);
    }
  }

  // Check if the new array contains empty input fields

  if (missingInput.length) {

    // Hide the mandatory fields disclaimer and make the missing fields disclaimer visible instead
    // preventDefault() prevents the form from being submitted

    $mandatoryFields.style.display = 'none';
    $missingFieldsCtn.style.display = 'block';
    event.preventDefault();
    for (let index in missingInput) {
      document.getElementById(missingInput[index]).style.border = '0.3rem solid var(--font-red)';
    }
  } else {

    // Check if the passwords match

    if ($password.value !== $passwordConfirm.value) {

      // Prevent the form from being submitted and show the mismatching passwords disclaimer

      event.preventDefault();
      $missingFieldsCtn.style.display = 'none';
      $passwordWrongCtn.style.display = 'block';
    }
  }
  }
);

