'use strict';

// Register all 'Complete' buttons

const $btnRed = Array.from(document.querySelectorAll('.btn-red'));

// Get the course ID from the corresponding GET variable

const urlString = window.location.href;
const Url = new URL(urlString);
const course_id = Url.searchParams.get("id");

// Register all course items on the navigation menu and calculate their total number

const $courseItems = Array.from(document.querySelectorAll('.course-item'));
const courseItemsNumber = $courseItems.length;

// Register the spinner

const $spinner = Array.from(document.querySelectorAll('.loader'));

// Loop through all buttons and add a click event

for (const INDEX in $btnRed) {
  $btnRed[INDEX].addEventListener('click', () => {

    // Register the current course completion from the corresponding HTML element with the progress attribute and convert it to an INT

    const currentProgress = parseInt(document.querySelector('#course-completion').getAttribute('progress'));

    // Calculate the new progress based on the current progress

    const newProgressPreparation = currentProgress + (100 / courseItemsNumber);

    // Convert the new progress INT to a number with two decimal places

    const newProgress = (Math.round(newProgressPreparation * 100) / 100).toFixed(2);

    // Register the current course completion in percent that is visible for the user (above the progress bar)

    const $courseCompletionPct = document.querySelector('#course-completion-pc');

    // If the button has the class 'completed' assigned, return so as to not execute the rest of the code (prevent the multiple completion of one item)

    if ($btnRed[INDEX].classList.contains('completed')) return;

    // Register the ordered number of the button so as to know to which course item it 'belongs'

    const btnHierarchy = $btnRed[INDEX].getAttribute('hierarchy');

    // Initiate a new XMLHttpRequest where completion.php is executed

    const XHR = new XMLHttpRequest();

    // Pass on the course ID, the item ID and the new progress to completion.php via GET variables

    XHR.open('Get', `ajax/completion.php?course_id=${course_id}&item_id=${btnHierarchy}&new_progress=${newProgress}`, true);
    XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    XHR.onload = function() {
      if (this.status >= 400) {
        $btnRed[INDEX].innerHTML = 'There was an internal server error. Please try again later.';
        return;
      }
    }
    XHR.onreadystatechange = () => {
      if (XHR.readyState === 4 && XHR.status >= 200 && XHR.status <= 500) {

          // Assign the response Test ('Completed') to the button and add the class 'completed'

          const returnData = XHR.responseText;
          $btnRed[INDEX].innerHTML = returnData;
          $spinner[INDEX].style.display = 'none';
          $btnRed[INDEX].classList.add('completed');

          // Append a tick to the completed element

          const $check = document.createElement('i');
          $check.classList.add('fas','fa-check-circle');
          $courseItems[INDEX].appendChild($check);

          // Display the new progress visible to the user above the progress bar

          const newProgressInt = parseInt(newProgress);
          $courseCompletionPct.innerHTML = `${newProgressInt}%`;

          // Extend the progress bar according to the new course completion percentage

          $progressBar.style.width = $courseCompletionPct.innerHTML;

          // Update the progress attribute for the corresponding HTML element

          document.querySelector('#course-completion').setAttribute('progress', $courseCompletionPct.innerHTML);
      }
    }

    // Add a timeout of 3 seconds for users to see a 'Processing' message
    setTimeout(() => {
      XHR.send();
    }, 3000)

    // 'Processing' should be displayed while the script is loading returnData from completion.php

    $btnRed[INDEX].innerHTML = 'Processing...';
    $spinner[INDEX].style.display = 'block';


  // Users should only be able to complete a specific item once

  }, { once: true });
}
