/**
 * Скрипт для работы с социальными сетями
 * Загружается с атрибутом async - выполняется как только загрузится, без сохранения порядка
 */

console.log("Социальный скрипт загружен (async)");

// Функция для инициализации социальных кнопок
function initSocialButtons() {
    const socialButtons = document.querySelectorAll('.social-link');
    
    if (socialButtons.length === 0) {
        console.warn("Социальные кнопки не найдены");
        return;
    }
    
    // Пример работы с коллекцией элементов
    socialButtons.forEach((button, index) => {
        button.addEventListener('mouseover', function() {
            console.log(`Наведение на социальную кнопку #${index + 1}`);
            
            // Пример анимации через JS
            this.style.transition = 'transform 0.3s ease';
            this.style.transform = 'scale(1.2)';
        });
        
        button.addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
        });
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const network = this.querySelector('i').className.split('-')[1];
            const message = `Вы собираетесь поделиться в ${network}. Продолжить?`;
            
            if (confirm(message)) {
                // В реальном коде здесь было бы перенаправление на API соцсети
                console.log(`Поделиться в ${network}`);
                window.open(this.href, '_blank');
            } else {
                console.log(`Отмена публикации в ${network}`);
            }
        });
    });
}

// Так как скрипт async, нужно проверить готовность DOM
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSocialButtons);
} else {
    initSocialButtons();
}

// Пример работы с Math
function getRandomSocialColor() {
    const colors = ['#3b5998', '#1da1f2', '#e1306c', '#0077b5'];
    const randomIndex = Math.floor(Math.random() * colors.length);
    return colors[randomIndex];
}

console.log("Случайный цвет для соц. кнопки:", getRandomSocialColor());

// Пример работы с датами и интервалами
const socialLoadTime = new Date();
setTimeout(() => {
    const diff = (new Date() - socialLoadTime) / 1000;
    console.log(`Социальный скрипт выполнялся ${diff} секунд`);
}, 2000);