let money = 100; // начальные деньги
let product = 0; // количество товара
let productPrice = 10; // начальная цена товара
let incomePerSecond = 0; // доход в секунду

// обновление отображаемых данных
function updateStats() {
  document.getElementById("money").innerText = money;
  document.getElementById("product").innerText = product;
  document.getElementById("product-price").innerText = productPrice;
  document.getElementById("income").innerText = incomePerSecond;
}

// Получение ежедневного приза
document.getElementById("claim-daily-prize")?.addEventListener("click", () => {
  let prize = Math.floor(Math.random() * 50) + 10; // случайная сумма
  money += prize;
  alert(`Вы получили ежедневный приз: ${prize} 💵`);
  updateStats();
});

// Тапалка (кнопка для производства)
document.getElementById("tap-button")?.addEventListener("click", () => {
  money += 1; // увеличение денег за клик
  updateStats();
});

// покупка товара
document.getElementById("buy-product")?.addEventListener("click", () => {
  if (money >= productPrice) {
    money -= productPrice;
    product += 1;
    updateStats();
  } else {
    alert("❌ Недостаточно денег!");
  }
});

// продажа товара
document.getElementById("sell-product")?.addEventListener("click", () => {
  if (product > 0) {
    product -= 1;
    money += productPrice;
    updateStats();
  } else {
    alert("❌ У вас нет товара для продажи!");
  }
});

// доход от фабрики каждую секунду
setInterval(() => {
  money += incomePerSecond;
  updateStats();
}, 1000);

updateStats();
