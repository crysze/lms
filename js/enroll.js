'use strict';

const $button = document.querySelector('button');
const $postEnroll = document.querySelector('#post-enroll');

const urlString = window.location.href;
const Url = new URL(urlString);
const course_id = Url.searchParams.get("id");

// Register the spinner
const $spinner = document.querySelector('.loader');


// Add an event listener that is triggered by clicking the "Enroll" button

$button.addEventListener("click", (event) => {

  if ($button.innerHTML === "Enroll") {

  const XHR = new XMLHttpRequest();
  XHR.open('Get', `ajax/enroll.php?id=${course_id}`, true);
  XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  XHR.onload = function() {
    if (this.status >= 400) {
        $button.innerHTML = 'There was an internal server error. Please try again later.';
        return;
      }
  }
  XHR.onreadystatechange = () => {
    if (XHR.readyState === 4 && XHR.status >= 200 && XHR.status < 400) {
        const returnData = XHR.responseText;

        if (XHR.status === 201) {
          setTimeout(() => {
            $spinner.style.display = 'none';
            $button.innerHTML = returnData;
            $postEnroll.hidden = false;
          }, 3000);
        }
    }
  }

  // Send the request

  XHR.send();

  // 'Processing' should be displayed while the script is loading the response from enroll.php

  $button.innerHTML = 'Processing...';
  $spinner.style.display = 'block';

  }

  // After the enrolment is completed, the button displays "Enter" and redirects the user to the course

  if ($button.innerHTML === "Enter") {
    const newURL = `course-items.php?id=${course_id}`
    window.location.href = newURL;
  }

});
