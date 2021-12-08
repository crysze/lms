'use strict';

// Register all needed HTML elements

const $radioBtns = Array.from(document.querySelectorAll("input[type='radio']"));
const $labels = Array.from(document.querySelectorAll('label'));
const $quizButton = document.querySelector('.question-complete-btn');
const $quizResponse = document.querySelector('#quiz-msg');
const $overlay = document.querySelector('#overlay');
const $main = document.querySelector('main');
const $continueBtn = document.querySelector('#quiz-continue');
const $btnHierarchyQuiz = document.querySelector('.course-item.quiz').getAttribute('hierarchy');
const $quizItem = document.querySelector('.course-item.quiz');
// Register the spinner
const $spinnerQuiz = document.querySelector('.loader-quiz');



// Register the value of the currently selected radio button in a globally accessible variable

for (const index in $radioBtns) {
  $radioBtns[index].addEventListener('click', () => {
    window.selectedValue = $radioBtns[index].value;
  });
}

// If the quiz has been completed before, the radio buttons should be disabled and the correct answer should be highlighted

if ($quizButton.innerHTML === 'Completed') {
    for (const index in $radioBtns) {
    $radioBtns[index].disabled = true;
  }

  for (const index in $labels) {
    const $labelValue = $labels[index].getAttribute('value');
    const XHR = new XMLHttpRequest();
    XHR.open('Get', `ajax/completed-quiz.php?answer_id=${$labelValue}`, true);
    XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    XHR.onreadystatechange = () => {
        if (XHR.readyState === 4 && XHR.status >= 200 && XHR.status <= 400) {
            const returnData = XHR.responseText;
            if (XHR.status === 202) {
                $labels[index].style.background = 'lightGreen';
            }
      }
    }
    XHR.send();
  }
}

// Add a click event to the quiz button

$quizButton.addEventListener('click', () => {

    if ($quizButton.innerHTML === 'Completed') return;

    // Register the current course completion from the corresponding HTML element with the progress attribute and convert it to an INT

    const currentProgress = parseInt(document.querySelector('#course-completion').getAttribute('progress'));

    // Calculate the new progress based on the current progress

    const newProgressPreparation = currentProgress + (100 / courseItemsNumber);

    // Convert the new progress INT to a number with two decimal places

    let newProgress = (Math.round(newProgressPreparation * 100) / 100).toFixed(2);

    // Register the current course completion in percent that is visible for the user (above the progress bar)

    const $courseCompletionPct = document.querySelector('#course-completion-pc');

  // Function to be used in all three cases when users click on "Submit Answer" (the response text must be inserted as the parameter):
  // - They haven't selected any answer
  // - Their answer was wrong
  // - Their answer was true

  function quizFeedback(quizResponse) {
    $overlay.style.display = 'flex';
    $quizResponse.innerHTML = quizResponse;
    $main.style.filter = 'blur(0.2rem)';
  }

  if (!window.selectedValue) {
    quizFeedback('Please select an answer!');
    return;
  }

  // Temporary workaround: if a value like 99.33 is calculated, the course should be marked as 100 % completed

  newProgress = newProgress.includes('99') ? '100' : newProgress;

  const XHR = new XMLHttpRequest();

  // Pass on the course ID, the current item order / hierarchy number, the answer ID and the calculated new progress to completion-quiz.php

  XHR.open('Get', `ajax/completion-quiz.php?course_id=${course_id}&item_id=${$btnHierarchyQuiz}&answer_id=${window.selectedValue}&new_progress=${newProgress}`, true);
  XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  XHR.onload = function() {
  if (this.status > 400) {
    $quizButton.innerHTML = 'There was an internal server error. Please try again later.';
    return;
  }
}
  XHR.onreadystatechange = () => {
    if (XHR.readyState === 4 && XHR.status >= 200 && XHR.status <= 400) {

        const returnData = XHR.responseText;
        $spinnerQuiz.style.display = 'none';

        if (XHR.status === 400) {
          quizFeedback('The answer you submitted was wrong. Please try again!');
          $quizButton.innerHTML = 'Submit Answer';
          return;
        }

        // ! Define what needs to happen if the answer was correct:

        quizFeedback('Congrats! You successfully passed the quiz.');

        // Add a green overlay to the correct answer

        const $rightAnswer = document.querySelector(`label[value='${window.selectedValue}']`);
        $rightAnswer.style.background = 'lightGreen';

        // Disable all radio buttons after the quiz has been passed

        for (const index in $radioBtns) {
          $radioBtns[index].disabled = true;
        }

        // Add a tick to the successfully completed item on the nav menu

        const $check = document.createElement('i');
        $check.classList.add('fas','fa-check-circle');
        $quizItem.appendChild($check);

        // Display the new progress visible to the user above the progress bar

        const newProgressInt = parseInt(newProgress);
        const newProgressStr = newProgressInt.toString();
        if (newProgressStr.includes('99') || newProgressStr > 100) {
            $courseCompletionPct.innerHTML = `100%`;
        } else {
            $courseCompletionPct.innerHTML = `${newProgressInt}%`;
        }

        // Extend the progress bar according to the new course completion percentage

        $progressBar.style.width = $courseCompletionPct.innerHTML;

        // Update the progress attribute for the corresponding HTML element

        document.querySelector('#course-completion').setAttribute('progress', $courseCompletionPct.innerHTML);

        // Assign the response text ('Completed') to the button and make it green

         $quizButton.innerHTML = 'Completed';
         $quizButton.style.background = 'green';
    }
  }

  // Add a timeout of 3 seconds for users to see a 'Processing' message
  setTimeout(() => {
    XHR.send();
  }, 3000)

  // 'Processing' should be displayed while the script is loading returnData from completion-quiz.php

  $quizButton.innerHTML = 'Processing...';
  $spinnerQuiz.style.display = 'block';

});

// Removes the overlay once 'continue' is clicked

$continueBtn.addEventListener('click', () => {
    $overlay.style.display = 'none';
    $quizResponse.innerHTML = '';
    $main.style.filter = '';

})





