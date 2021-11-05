'use strict';

// Register left and right arrow as well as the slider container - all elements are assigned to an array where a for loop can then be used to iterate over them all

const arrowLeft = Array.from(document.querySelectorAll('.fa-caret-left'));
const arrowRight = Array.from(document.querySelectorAll('.fa-caret-right'));

const sliderCtn = Array.from(document.querySelectorAll('.widget-sub-ctn'));

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
    const sliderEndNumber = (allCourses.length - 3) * widgetWidth;

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



