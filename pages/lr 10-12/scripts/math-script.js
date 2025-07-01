// Главная функция, которая инициализирует все обработчики
function initMathFunction() {
    // Получаем элементы DOM
    const calculateBtn = document.getElementById('calculateBtn');
    const resultOutput = document.getElementById('resultOutput');
    const xInput = document.getElementById('xValue');
    const canvas = document.getElementById('graphCanvas');
    
    // Функция для расчета y по формуле с обработкой ошибок
    function calculateY(x) {
        try {
            const expression = 9 - Math.pow(x, 2);
            
            if (expression < 0) {
                throw new Error("Ошибка: подкоренное выражение отрицательное");
            }
            
            const y = (2/3) * Math.sqrt(expression);
            return y;
        } catch (error) {
            alert(error.message);
            return null;
        }
    }
    
    // Функция для отображения результата расчета
    function showResult() {
        const x = parseFloat(xInput.value);
        
        if (isNaN(x)) {
            alert("Пожалуйста, введите корректное число");
            return;
        }
        
        const y = calculateY(x);
        if (y !== null) {
            resultOutput.innerHTML = `Для x = ${x.toFixed(2)}:<br>
                                     y = (2/3) * √(9 - ${x.toFixed(2)}²) = ${y.toFixed(4)}`;
        }
    }
    
    // Функция для рисования графика
    function drawGraph() {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;
        
        // Очищаем canvas
        ctx.clearRect(0, 0, width, height);
        
        // Рисуем оси координат
        ctx.beginPath();
        ctx.moveTo(0, height/2);
        ctx.lineTo(width, height/2);
        ctx.moveTo(width/2, 0);
        ctx.lineTo(width/2, height);
        ctx.strokeStyle = '#000';
        ctx.stroke();
        
        // Рисуем график функции
        ctx.beginPath();
        for (let x = -3; x <= 3; x += 0.05) {
            const y = calculateY(x);
            if (y !== null) {
                const pixelX = width/2 + x * 50;
                const pixelY = height/2 - y * 50;
                
                if (x === -3) {
                    ctx.moveTo(pixelX, pixelY);
                } else {
                    ctx.lineTo(pixelX, pixelY);
                }
            }
        }
        ctx.strokeStyle = 'red';
        ctx.lineWidth = 2;
        ctx.stroke();
        
        // Подписываем оси
        ctx.font = '14px Arial';
        ctx.fillStyle = 'black';
        ctx.fillText('x', width - 15, height/2 - 5);
        ctx.fillText('y', width/2 + 10, 15);
    }
    
    // Назначаем обработчики событий
    calculateBtn.addEventListener('click', showResult);
    
    // Рисуем график при загрузке
    drawGraph();
}

// Инициализируем при полной загрузке DOM
document.addEventListener('DOMContentLoaded', initMathFunction);