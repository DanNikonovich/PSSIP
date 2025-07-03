/**
 * Основной скрипт сайта
 * Загружается синхронно, блокирует отображение страницы
 */

console.log("Основной скрипт загружен");

// Функция для отслеживания кликов по странице
function trackClicks() {
    document.addEventListener('click', function(event) {
        console.log(`Клик по элементу: ${event.target.tagName}`);
        
        // Пример сложной логики с операторами
        const isExternalLink = event.target.closest('a[href^="http"]') && 
                              !event.target.closest('a[href*="'+window.location.host+'"]');
        
        if (isExternalLink) {
            event.preventDefault();
            const proceed = confirm(`Вы покидаете сайт. Перейти по ссылке ${event.target.href}?`);
            if (proceed) {
                window.open(event.target.href, '_blank');
            }
        }
    });
}

// Инициализация функций при полной загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM полностью загружен");
    trackClicks();
    
    // Пример работы с датами
    const currentDate = new Date();
    console.log(`Текущая дата: ${currentDate.toLocaleDateString()}`);
    
    // Пример работы с массивами
    const skills = ['HTML', 'CSS', 'JavaScript'];
    skills.push('React');
    console.log(`Навыки: ${skills.join(', ')}`);
});

// Пример работы с объектами
const portfolioData = {
    owner: "Dan Nikonovich",
    projects: 12,
    getInfo: function() {
        return `${this.owner}, проектов: ${this.projects}`;
    }
};

console.log(portfolioData.getInfo());