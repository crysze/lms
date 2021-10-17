'use strict';

// Register the HTML element that displays the progress bar

const $progressBar = document.querySelector('#progress-bar-filled');

// Get the progress from the database via a custom HTML attribute ("progress") and set it as a percentage value

const $progress = `${$progressBar.getAttribute('progress')}%`;

// Assign the actual progress to the porgress bar

$progressBar.style.width = $progress;

// Highlight the first video as active by default

const courseItem = document.querySelector('.course-item');
courseItem.classList.add('active');

const previous = document.querySelector('#previous-ctn');
const next = document.querySelector('#next-ctn');

const videoHierarchy = document.querySelector('#video-order');
if (videoHierarchy.innerHTML === "1") {
   previous.remove();
}






