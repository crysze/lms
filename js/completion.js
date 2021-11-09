'use strict';

const $btnRed = Array.from(document.querySelectorAll('.btn-red'));

const urlString = window.location.href;
const Url = new URL(urlString);
const course_id = Url.searchParams.get("id");

const $courseItems = Array.from(document.querySelectorAll('.course-item'));
const courseItemsNumber = $courseItems.length;


for (const INDEX in $btnRed) {
  $btnRed[INDEX].addEventListener('click', () => {

    const currentProgress = parseInt(document.querySelector('#course-completion').getAttribute('progress'));
    const newProgressPreparation = currentProgress + (100 / courseItemsNumber);
    const newProgress = (Math.round(newProgressPreparation * 100) / 100).toFixed(2);

    const $courseCompletionPct = document.querySelector('#course-completion-pc');

    if ($btnRed[INDEX].classList.contains('completed')) return;

    const btnHierarchy = $btnRed[INDEX].getAttribute('hierarchy');
    const XHR = new XMLHttpRequest();
    XHR.open('Get', `completion.php?course_id=${course_id}&item_id=${btnHierarchy}&new_progress=${newProgress}`, true);
    XHR.onreadystatechange = () => {
      if (XHR.readyState === 4 && XHR.status === 200) {
          const returnData = XHR.responseText;
          $btnRed[INDEX].innerHTML = returnData;
          $btnRed[INDEX].classList.add('completed');

          const $check = document.createElement('i');
          $check.classList.add('fas','fa-check-circle');
          $courseItems[INDEX].appendChild($check);

          const newProgressInt = parseInt(newProgress);
          $courseCompletionPct.innerHTML = `${newProgressInt}%`;
          $progressBar.style.width = $courseCompletionPct.innerHTML;
          document.querySelector('#course-completion').setAttribute('progress', $courseCompletionPct.innerHTML);


      }
    }

    // Send the form values to register.php
    setTimeout(() => {
      XHR.send();
    }, 3000)

    // 'Processing' should be displayed while the script is loading returnData from register.php

    $btnRed[INDEX].innerHTML = 'Processing...';

  }, { once: true });
}
