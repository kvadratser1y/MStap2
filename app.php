<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMJ COIN</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: linear-gradient(to right, #ff7e5f, #feb47b); /* Добавлен градиентный фон */
        background-size: cover;
    }

    .container {
        text-align: center;
        background: rgba(255, 255, 255, 0.8); /* Полупрозрачный белый фон для контейнера */
        border-radius: 15px;
        padding: 20px;
    }

    #balance {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .click-area {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        margin-bottom: 20px;
        overflow: hidden;
        position: relative;
        background: url('https://example.com/bottle.png') no-repeat center center;
        background-size: cover;
        outline: none;
        transition: transform 0.1s;
    }

    .click-area:active {
        transform: scale(0.9);
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        background-color: rgba(255, 255, 255, 0.7);
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .leaderboard {
        margin-top: 20px;
    }

    .leaderboard h2 {
        margin: 0;
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .leaderboard ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .leaderboard li {
        background-color: #fff;
        padding: 5px;
        margin-bottom: 5px;
        border-radius: 3px;
        color: #333;
    }

    :active, :hover, :focus {
        outline: 0;
        outline-offset: 0;
        outline: 0 !important;
        outline-color: transparent !important;
        outline-width: 0 !important;
        outline-style: none !important;
        box-shadow: 0 0 0 0 rgba(0,123,255,0) !important;
    }

    div::-moz-focus-inner {
        border: 0;
        outline: 0 !important;
        outline-color: transparent !important;
        outline-width: 0 !important;
        outline-style: none !important;
        box-shadow: 0 0 0 0 rgba(0,123,255,0) !important;
    }

    img::-moz-focus-inner {
        border: 0;
        outline: 0 !important;
        outline-color: transparent !important;
        outline-width: 0 !important;
        outline-style: none !important;
        box-shadow: 0 0 0 0 rgba(0,123,255,0) !important;
    }

    :focus {
        outline-style: none;
        outline-width: 0px !important;
        outline-color: none !important;
    }

    :active, :hover, :focus {
        outline: 0;
        outline-offset: 0;
    }

    :focus {
        outline: none !important;
    }

    ::-moz-focus-inner {
        border: 0px !important;
    }

    *:focus {
        outline: 0;
        border: transparent;
    }
    </style>
</head>
<body>
    <div class="container">
        <div id="balance">Баланс: <span id="balance_num">0.000000000</span> BMJ</div>
        <div id="click-area" class="click-area"></div>
        <div id="leaderboard" class="leaderboard">
            <h2>ТОП-5 Игроков</h2>
            <ul id="leaderboard-list">
                <!-- Лидеры будут динамически добавляться здесь -->
            </ul>
        </div>
    </div>
    
    <audio id="click-sound" src="https://example.com/click.mp3?1"></audio>
    <audio id="scream-sound" src="https://example.com/scream.mp3"></audio>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
    Telegram.WebApp.ready();

    const user = Telegram.WebApp.initDataUnsafe.user;
    const clickSound = document.getElementById('click-sound');
    const screamSound = document.getElementById('scream-sound');

    // Функция обновления баланса и таблицы лидеров
    function updateUI(response) {
        const json = jQuery.parseJSON(response);
        const formattedBalance = parseFloat(json.balance).toFixed(9);
        const newBalance = parseFloat(json.balance);
        $("#balance_num").html(formattedBalance);

        // Проверка кратности
        if ((newBalance * 1000000000) % 1000 === 0) {
            screamSound.play();
        }

        const leaderboardList = $("#leaderboard-list");
        leaderboardList.empty();

        const leaders = json.leaders.slice(0, 5); // Берем только первых 5 лидеров
        leaders.forEach(leader => {
            const formattedLeaderBalance = parseFloat(leader.balance).toFixed(9);
            const listItem = `<li>${leader.name}: ${formattedLeaderBalance} BMJ</li>`;
            leaderboardList.append(listItem);
        });
    }

    // Получаем текущий баланс и лидеров при загрузке страницы
    $.ajax({
      method: "POST",
      url: "https://example.com/api/tap.php",
      data: { user_id: user.id, user_name: user.username }
    }).done(function(response) {
        updateUI(response);
    });

    // Обработка кликов и обновление баланса
    document.querySelector('.click-area').addEventListener('click', (event) => {
        // Создаем эффект ряби
        const circle = document.createElement('div');
        circle.classList.add('ripple');
        circle.style.width = circle.style.height = `${Math.max(event.target.clientWidth, event.target.clientHeight)}px`;
        circle.style.left = `${event.clientX - event.target.offsetLeft - circle.offsetWidth / 2}px`;
        circle.style.top = `${event.clientY - event.target.offsetTop - circle.offsetHeight / 2}px`;

        event.target.appendChild(circle);

        setTimeout(() => circle.remove(), 600);

        // Вибрация при клике
        if (navigator.vibrate) {
            navigator.vibrate(50); // Вибрация на 50 миллисекунд
        }

        // Воспроизведение звука при клике
        clickSound.play();

        $.ajax({
            method: "POST",
            url: "https://example.com/api/tap.php",
            data: { user_id: user.id, user_name: user.username },
            success: function(response) {
                updateUI(response);
            }
        });
    });

    // Убираем фокус с элемента при нажатии
    document.querySelector('.click-area').addEventListener('mousedown', (event) => {
        event.preventDefault();
    });
    </script>
</body>
</html>
