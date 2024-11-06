// Главная страница игры
if (!localStorage.getItem('username')) {
  window.location.href = 'reg.html';  // Перенаправление на страницу регистрации, если не зарегистрирован
}

// Отображаем никнейм пользователя
const username = localStorage.getItem('username');
document.getElementById("username").innerText = username; // Выводим имя пользователя

// Главная логика игры
let money = localStorage.getItem('money') ? parseInt(localStorage.getItem('money')) : 100;
let product = localStorage.getItem('product') ? parseInt(localStorage.getItem('product')) : 0;
let income = localStorage.getItem('income') ? parseInt(localStorage.getItem('income')) : 0;

function updateStats() {
  document.getElementById('money').innerText = money;
  document.getElementById('product').innerText = product;
  document.getElementById('income').innerText = income;
}

document.getElementById("tap-button").addEventListener("click", () => {
  money += 10;
  product += 1;
  localStorage.setItem('money', money);
  localStorage.setItem('product', product);
  updateStats();
});

updateStats();
