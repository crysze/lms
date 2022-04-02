'use strict';

// Search funtion

// Register the input field, define an array with set tags and another empty array to fill with tags that fit the user's input

const searchInput = document.querySelector('input');

// A yet empty array that will be filled via fetch API with all current tags from the database

const searchTags = [];

async function fetchTags() {
  let response = await fetch('ajax/tags.php', {

    // This header has to be set manually with the fetch API, if the ajax PHP files should be protected from being accessed directly when users access their URLs (see first line of code of all ajax PHP files)
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  });

  // If a successful status code of 200 is sent back, the JSON file is parsed into an object and then converted into an array

  if (response.status === 200) {
      let data = await response.text();
      let JSONObj = JSON.parse(data);
      for(let value of JSONObj)
        searchTags.push(value);
  } else return;
}

fetchTags();

const searchMatches = [];
const suggestionsCtn = document.querySelector('#suggestions-ctn');

// Whenever the user inputs sth. into the input field, a callback function is executed that adds and subtracts matching tags

searchInput.addEventListener('input', () => {

  // Make suggestions visible when the user starts typing in the search fields

  suggestionsCtn.style.visibility = 'visible';

  // Get all suggestion items and remove them each time the input is updated by the user so as not to have duplicate tags showing up

  let suggestionItems = Array.from(document.querySelectorAll('.suggestion-item'));

  if (suggestionItems) {
    for (let suggestionItem of suggestionItems) {
      suggestionsCtn.removeChild(suggestionItem);
    }
  }

  searchTags.forEach((element) => {

    // If a user's input matches an element from the array and this element is not yet added, it will get pushed as a new value to the array

    if (element.toLowerCase().startsWith(searchInput.value.toLowerCase()) && !searchMatches.includes(element)) {
          searchMatches.push(element);
    }

    // Continuously check with each new input if strings already included in the array still match the input - if not, remove them from the array

    if (searchMatches.length !== 0 && searchMatches.includes(element) && !element.toLowerCase().startsWith(searchInput.value.toLowerCase())) {
      let index = searchMatches.indexOf(element);
      searchMatches.splice(index, 1);
    }
  });

  // Display "No suggestions" if no string is matched in the search matches array

  document.querySelector('#suggestions-title').innerHTML = searchMatches.length === 0 ? 'No suggestions' : 'Suggestions';

  // With each new input, the updated search matches array is converted into span elements to show up as suggestions

  searchMatches.forEach((element) => {

    // Get the length of the user's input string, separate it from the rest of the matched word and highlight the part the user already typed in in red

    let inputLength = searchInput.value.length;
    let matchedText = element.slice(0, inputLength);
    let restText = element.slice(inputLength);

    let span = document.createElement('span');
    span.classList.add('suggestion-item');
    span.innerHTML = `<a href="search.php?result=${element}"><span class="matched-text">${matchedText}</span>${restText}</a>`;
    suggestionsCtn.appendChild(span);
  });
});

// Sliders

// Register left and right arrow as well as the slider container - all elements are assigned to an array where a for loop can then be used to iterate over them all

const arrowLeft = Array.from(document.querySelectorAll('.fa-caret-left'));
const arrowRight = Array.from(document.querySelectorAll('.fa-caret-right'));

const sliderCtn = Array.from(document.querySelectorAll('.widget-sub-ctn'));

let noOfCourses = 0;

if (screen.width > 848) noOfCourses = 3;
if (screen.width <= 848 && screen.width > 598) noOfCourses = 2;
if (screen.width <= 678) noOfCourses = 1;

// Slider functionality when clicking on the arrows

for (let i = 0; i < sliderCtn.length; i++) {

  // Register the widgetWidth that is currently 24.7rem

  const widgetWidth = 24.7;

  // Create one function for each arrow that checks whether the conditions are met to display them - the left arrow should only be displayed if "scrolling" to the left is possible and vice versa for the right arrow

  function arrowLeftVisibility() {

    // If the transform property is an empty string (when the page is loaded for the first time) or is specifically set to 0rem, then the arrow should be hidden - otherwise it should be displayed

    // The visibility property was used because even when the element is hidden, it takes up its usual space and therefore no elements will be moved when the arrow becomes visible again

    if (!sliderCtn[i].style.transform || sliderCtn[i].style.transform === 'translateX(0rem)') {
      arrowLeft[i].style.visibility = 'hidden';
    } else {
      arrowLeft[i].style.visibility = 'visible';
    }
  }

  function arrowRightVisibility() {

    // All child elements of the slider with the .widget class are selected and counted
    // 3 is the default number of courses that are displayed at any time in the slider - therefore, the total amount of courses in that category is counted, three is subtracted and the result is multiplied with the widgetWith (currently 24.7rem)

    const allCourses = sliderCtn[i].querySelectorAll('.widget');
    const sliderEndNumber = (allCourses.length - noOfCourses) * widgetWidth;

    // If the transform property has a translateX value that was calculated before, there are no more courses to "scroll" and therefore the right arrow is hidden - otherwise it's visible

    if (sliderCtn[i].style.transform === `translateX(-${sliderEndNumber}rem)`) {
      arrowRight[i].style.visibility = 'hidden';
    } else {
      arrowRight[i].style.visibility = 'visible';
    }
  }

  // The arrowLeftVisibility function is called when the page is loaded to hide the left arrow by default

  arrowLeftVisibility();

  // When the left arrow is clicked, the widgetWidth is added to the current value of translateX which is isolated by using the .replace method and regEx
  // Since the regEx method only returns the positive value, a - is added when assigning the newTranslateX value
  // Both arrow visibility functions are called to check if the arrows should still be displayed

  arrowLeft[i].addEventListener('click', () => {
    const currentTranslateX = sliderCtn[i].style.transform.replace(/[^\d.]/g, '');
    const newTranslateX = -currentTranslateX + widgetWidth;
    sliderCtn[i].style.transform = `translateX(${newTranslateX}rem)`;
    arrowLeftVisibility();
    arrowRightVisibility();
  });

    // When the right arrow is clicked, the widgetWidth is subtracted from the current value of translateX which is isolated by using the .replace method and regEx
      // Since the regEx method only returns the positive value, a - is added when assigning the newTranslateX value
      // Both arrow visibility functions are called to check if the arrows should still be displayed

  arrowRight[i].addEventListener('click', () => {
    const currentTranslateX = sliderCtn[i].style.transform.replace(/[^\d.]/g, '');
    const newTranslateX = -currentTranslateX - widgetWidth;
    sliderCtn[i].style.transform = `translateX(${newTranslateX}rem)`;
    console.log(sliderCtn[i].style.transform);
    arrowLeftVisibility();
    arrowRightVisibility();
  });
}



