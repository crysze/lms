'use strict';

// Register the HTML element that displays the progress bar

const $progressBar = document.querySelector('#progress-bar-filled');

// Get the progress from the database via a custom HTML attribute ("progress") and set it as a percentage value

const $progress = `${$progressBar.getAttribute('progress')}%`;

// Assign the actual progress to the porgress bar

$progressBar.style.width = $progress;

// Highlight the first video as active by default

const $courseItem = document.querySelector('.course-item');
$courseItem.classList.add('active');

// Register the "previous" and "next" HTML elements

const $previous = document.querySelector('#previous-ctn');
const $next = document.querySelector('#next-ctn');

// Remove the "previous" HTML element if the selected video is the first in the course (and therefore has no previous item)

const $videoHierarchy = document.querySelector('#video-order');
if ($videoHierarchy.innerHTML === "1") {
   $previous.remove();
}

// Register the navigation item for the quiz, the 'previous' and 'next' options in bulk and the "Complete item" button

const $quizNav = document.querySelector('.quiz');
const $videoNav = document.querySelector('#video-nav-ctn');
const $completeBtn = document.querySelector('#item-completion-ctn');

// Register the navigation items and the videos

const $navigation = Array.from(document.querySelectorAll('.course-item'));
const $content = Array.from(document.querySelectorAll('.content-sub-ctn'));

// Variable that will be used in the loop to store the index of the newly selected tab

let selectedVideo = 0;

// Assign a click event to all navigation items

for (const INDEX in $navigation) {

  $navigation[INDEX].addEventListener('click', () => {

    // Make the currently selected item non-clickable

    if (selectedVideo === INDEX) {
      return;
    }

    // On click, the previously selected item will lose its highlight and will be hidden

    $navigation[selectedVideo].classList.remove('active');
    $content[selectedVideo].hidden = true;

    // The newly selected item will be highlighted and not be hidden anymore

    $navigation[INDEX].classList.add('active');
    $content[INDEX].hidden = false;

   // Store the number of the newly selected item for the next loop

    selectedVideo = INDEX;

   // Hide the 'next' and 'previous' option and the completion button if the quiz is selected and show it again if it's not selected

   if ($quizNav.classList.contains('active')) {
      $videoNav.style.display = 'none';
      $completeBtn.style.display = 'none';
    } else {
      $videoNav.style.display = 'flex';
      $completeBtn.style.display = 'flex';
    }
  });

}






