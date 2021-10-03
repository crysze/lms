'use strict';

const $button = document.querySelector('button');
const $postEnroll = document.querySelector('#post-enroll');

const urlString = window.location.href;
const Url = new URL(urlString);
const course_id = Url.searchParams.get("id");

// Add an event listener that is triggered by clicking the "Enroll" button

$button.addEventListener("click", (event) => {

  if ($button.innerHTML === "Enroll") {

  const XHR = new XMLHttpRequest();
  XHR.open('Get', `enroll.php?id=${course_id}`, true);
  XHR.onreadystatechange = () => {
    if (XHR.readyState === 4 && XHR.status === 200) {
        const returnData = XHR.responseText;
        setTimeout(() => {
          $postEnroll.hidden = false;
          $button.innerHTML = returnData;
        }, 3000);
    }
  }

  // Send the request

  XHR.send();

  // 'Processing' should be displayed while the script is loading the response from enroll.php

  $button.innerHTML = 'Processing...';
  }
});

