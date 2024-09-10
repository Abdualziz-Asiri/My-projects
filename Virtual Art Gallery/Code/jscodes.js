const menuButton = document.getElementById('menuButton');
const menu = document.querySelector('.menu');

menuButton.addEventListener('click', () => {
  menu.classList.toggle('show');
  menuButton.classList.toggle('hide');
});
