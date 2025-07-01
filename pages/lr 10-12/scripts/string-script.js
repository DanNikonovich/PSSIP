// Главная функция для работы со строками
function initStringOperations() {
    const stringOutput = document.getElementById('stringOutput');
    
    // Исходные строки
    const S1 = "Я люблю Беларусь";
    const S2 = "Я учусь в Гродненском Государственном Политехническом колледже";
    
    // 1. Определить длину строки S2
    const s2Length = S2.length;
    stringOutput.innerHTML += `<p>1. Длина строки S2: <strong>${s2Length}</strong> символов</p>`;
    
    // 2. Проверить наличие слова "Беларусь" в S1
    const containsBelarus = S1.includes("Беларусь");
    stringOutput.innerHTML += `<p>2. Слово "Беларусь" <strong>${containsBelarus ? 'присутствует' : 'отсутствует'}</strong> в строке S1</p>`;
    
    // 3. 9-й символ строки S2 и его ASCII-код
    const charPosition = 9;
    const char = S2.charAt(charPosition - 1); // charAt использует индексацию с 0
    const charCode = S2.charCodeAt(charPosition - 1);
    
    stringOutput.innerHTML += `<p>3. ${charPosition}-й символ строки S2: <strong>'${char}'</strong> (ASCII-код: <strong>${charCode}</strong>)</p>`;
    
    // Дополнительная информация о символе
    stringOutput.innerHTML += `<p>Дополнительно: символ '${char}' - это ${getCharDescription(charCode)}</p>`;
    
    // Пользовательская функция для обработки строк
    function processStrings(str1, str2) {
        try {
            if (typeof str1 !== 'string' || typeof str2 !== 'string') {
                throw new Error("Оба аргумента должны быть строками");
            }
            return str1 + " | " + str2;
        } catch (error) {
            alert(`Ошибка обработки строк: ${error.message}`);
            return null;
        }
    }
    
    // Вспомогательная функция для описания символа
    function getCharDescription(code) {
        if (code >= 48 && code <= 57) return 'цифра';
        if (code >= 65 && code <= 90) return 'заглавная латинская буква';
        if (code >= 97 && code <= 122) return 'строчная латинская буква';
        if (code >= 1040 && code <= 1103) return 'русская буква';
        return 'специальный символ или буква другого алфавита';
    }
    
    // Пример использования функции обработки строк
    const combinedStrings = processStrings(S1, S2);
    if (combinedStrings) {
        stringOutput.innerHTML += `<p>4. Результат обработки строк: <strong>${combinedStrings}</strong></p>`;
    }
}

// Инициализация после загрузки DOM
document.addEventListener('DOMContentLoaded', initStringOperations);