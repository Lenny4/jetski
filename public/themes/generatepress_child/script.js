// https://www.w3schools.com/howto/howto_js_accordion.asp
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", (e) => {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    e.target.classList.toggle("dashicons-minus");
    e.target.classList.toggle("dashicons-plus");

    /* Toggle between hiding and showing the active panel */
    var panel = e.target.parentElement.parentElement.querySelector('ul.sub-menu');
    if (panel.style.display === "none") {
      panel.style.display = "block";
    } else {
      panel.style.display = "none";
    }
  });
}
