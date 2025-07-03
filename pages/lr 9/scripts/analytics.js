/**
 * Скрипт аналитики
 * Загружается с атрибутом defer - выполняется после полной загрузки DOM в порядке объявления
 */

console.log("Аналитика инициализирована (defer)");

// Функция для сбора аналитики
function initAnalytics() {
    // Имитация отправки данных в аналитическую систему
    const analyticsData = {
        pageUrl: window.location.href,
        screenResolution: `${window.screen.width}x${window.screen.height}`,
        viewportSize: `${window.innerWidth}x${window.innerHeight}`,
        userAgent: navigator.userAgent,
        timestamp: new Date().toISOString()
    };
    
    console.log("Отправка данных аналитики:", analyticsData);
    
    // Пример использования try-catch
    try {
        // В реальном коде здесь был бы fetch или XMLHttpRequest
        localStorage.setItem('lastAnalytics', JSON.stringify(analyticsData));
        console.log("Данные аналитики сохранены");
    } catch (error) {
        console.error("Ошибка при сохранении аналитики:", error);
    }
}

// Используем событие load для гарантии загрузки всех ресурсов
window.addEventListener('load', function() {
    console.log("Все ресурсы загружены, инициализируем аналитику");
    initAnalytics();
    
    // Пример работы с временными интервалами
    let counter = 0;
    const intervalId = setInterval(() => {
        counter++;
        console.log(`Аналитика активна уже ${counter} сек.`);
        if (counter >= 5) {
            clearInterval(intervalId);
            console.log("Мониторинг завершен");
        }
    }, 1000);
});

// Пример работы с JSON
const userSettings = {
    theme: 'dark',
    notifications: true,
    fontSize: 16
};

const jsonString = JSON.stringify(userSettings);
console.log("Строка JSON:", jsonString);