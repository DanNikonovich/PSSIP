// Основные демонстрационные функции

function outputToSection(sectionId, content, isError = false) {
    const outputElement = document.getElementById(sectionId);
    outputElement.textContent = content;
    outputElement.className = `output ${isError ? 'error' : 'success'}`;
}

function clearAllOutputs() {
    const outputs = document.querySelectorAll('.output');
    outputs.forEach(output => {
        output.textContent = '';
        output.className = 'output';
    });
}

// 1. Что такое объекты в JavaScript
function demoSection1() {
    const builtInObjects = {
        description: "Встроенные объекты JavaScript:",
        examples: [
            "Object - базовый объект",
            "Array - для работы с массивами", 
            "String - для работы со строками",
            "Math - математические операции",
            "Date - работа с датами и временем",
            "JSON - работа с JSON данными"
        ]
    };

    let output = `${builtInObjects.description}\n\n`;
    builtInObjects.examples.forEach((example, index) => {
        output += `${index + 1}. ${example}\n`;
    });

    output += "\nПримеры использования:\n";
    output += `Math.PI = ${Math.PI}\n`;
    output += `new Date() = ${new Date()}\n`;
    output += `Array.isArray([]) = ${Array.isArray([])}\n`;
    output += `JSON.stringify({name: "John"}) = ${JSON.stringify({name: "John"})}`;

    outputToSection('output1', output);
}

// 2. Пользовательские объекты
function demoSection2() {
    // Создание объекта с помощью литерала
    const student = {
        firstName: "Иван",
        lastName: "Петров",
        age: 20,
        course: 2,
        subjects: ["Математика", "Программирование", "Физика"],
        
        getFullName: function() {
            return `${this.firstName} ${this.lastName}`;
        },
        
        getInfo() {
            return `${this.getFullName()}, ${this.age} лет, ${this.course} курс`;
        }
    };

    // Создание объекта с помощью конструктора
    function Book(title, author, year) {
        this.title = title;
        this.author = author;
        this.year = year;
        this.getBookInfo = function() {
            return `"${this.title}" - ${this.author} (${this.year})`;
        };
    }

    const book1 = new Book("JavaScript для начинающих", "Алексей Иванов", 2023);

    let output = "Объект student (создан литералом):\n";
    output += JSON.stringify(student, null, 2);
    output += "\n\nМетоды объекта student:\n";
    output += `student.getFullName() = ${student.getFullName()}\n`;
    output += `student.getInfo() = ${student.getInfo()}`;

    output += "\n\nОбъект book1 (создан конструктором):\n";
    output += JSON.stringify(book1, null, 2);
    output += `\nbook1.getBookInfo() = ${book1.getBookInfo()}`;

    outputToSection('output2', output);
}

// 3. Доступ к свойствам
function demoSection3() {
    const person = {
        name: "Мария",
        age: 25,
        profession: "Разработчик",
        "favorite-color": "синий" // свойство с дефисом
    };

    let output = "Объект person:\n";
    output += JSON.stringify(person, null, 2);
    
    output += "\n\nДоступ через точечную нотацию:\n";
    output += `person.name = ${person.name}\n`;
    output += `person.age = ${person.age}`;
    
    output += "\n\nДоступ через скобочную нотацию:\n";
    output += `person['profession'] = ${person['profession']}\n`;
    output += `person['favorite-color'] = ${person['favorite-color']}`;
    
    output += "\n\nДинамический доступ:\n";
    const dynamicKey = 'age';
    output += `const dynamicKey = 'age';\n`;
    output += `person[dynamicKey] = ${person[dynamicKey]}`;

    outputToSection('output3', output);
}

// 4. Удаление свойств
function demoSection4() {
    const car = {
        brand: "Toyota",
        model: "Camry", 
        year: 2020,
        color: "синий",
        price: 25000,
        features: ["кондиционер", "кожаный салон"]
    };

    let output = "Исходный объект car:\n";
    output += JSON.stringify(car, null, 2);
    
    // Удаление свойств
    delete car.price;
    delete car['color'];
    
    output += "\n\nПосле удаления свойств:\n";
    output += "delete car.price;\n";
    output += "delete car['color'];\n\n";
    output += JSON.stringify(car, null, 2);
    
    output += "\n\nПопытка удалить несуществующее свойство:\n";
    output += `delete car.unknownProperty = ${delete car.unknownProperty}`;

    outputToSection('output4', output);
}

// 5. Проверка существования свойств
function demoSection5() {
    const employee = {
        name: "Сергей",
        position: "Менеджер",
        salary: 60000,
        department: "Продажи"
    };

    let output = "Объект employee:\n";
    output += JSON.stringify(employee, null, 2);
    
    output += "\n\nПроверка с помощью оператора in:\n";
    output += `'name' in employee = ${'name' in employee}\n`;
    output += `'age' in employee = ${'age' in employee}\n`;
    output += `'toString' in employee = ${'toString' in employee}`;
    
    output += "\n\nПроверка с помощью hasOwnProperty():\n";
    output += `employee.hasOwnProperty('position') = ${employee.hasOwnProperty('position')}\n`;
    output += `employee.hasOwnProperty('experience') = ${employee.hasOwnProperty('experience')}\n`;
    output += `employee.hasOwnProperty('toString') = ${employee.hasOwnProperty('toString')}`;

    outputToSection('output5', output);
}

// 6. Перебор свойств
function demoSection6() {
    const product = {
        id: 1,
        name: "Смартфон",
        category: "Электроника", 
        price: 500,
        inStock: true,
        features: ["6.1\" экран", "128GB", "Двойная камера"]
    };

    let output = "Объект product:\n";
    output += JSON.stringify(product, null, 2);
    
    output += "\n\nПеребор с помощью for...in:\n";
    for (let key in product) {
        if (product.hasOwnProperty(key)) {
            output += `  ${key}: ${product[key]}\n`;
        }
    }
    
    output += "\nПеребор с помощью Object.keys():\n";
    Object.keys(product).forEach(key => {
        output += `  ${key}: ${product[key]}\n`;
    });
    
    output += "\nПеребор с помощью Object.values():\n";
    output += `  ${Object.values(product).join(', ')}`;
    
    output += "\n\nПеребор с помощью Object.entries():\n";
    Object.entries(product).forEach(([key, value]) => {
        output += `  ${key}: ${value}\n`;
    });

    outputToSection('output6', output);
}

// Дополнительные примеры
function demoAdditional() {
    let output = "ДОПОЛНИТЕЛЬНЫЕ ПРИМЕРЫ\n\n";
    
    // Копирование объектов
    output += "1. Копирование объектов:\n";
    const original = { a: 1, b: 2, c: { d: 3 } };
    const shallowCopy = { ...original };
    const deepCopy = JSON.parse(JSON.stringify(original));
    
    output += `original: ${JSON.stringify(original)}\n`;
    output += `shallowCopy: ${JSON.stringify(shallowCopy)}\n`;
    output += `deepCopy: ${JSON.stringify(deepCopy)}\n`;
    
    // Слияние объектов
    output += "\n2. Слияние объектов:\n";
    const obj1 = { a: 1, b: 2 };
    const obj2 = { b: 3, c: 4 };
    const merged = { ...obj1, ...obj2 };
    output += `obj1: ${JSON.stringify(obj1)}\n`;
    output += `obj2: ${JSON.stringify(obj2)}\n`;
    output += `merged: ${JSON.stringify(merged)}\n`;
    
    // Деструктуризация
    output += "\n3. Деструктуризация объектов:\n";
    const user = { name: "Анна", age: 30, city: "Москва" };
    const { name, age, city } = user;
    output += `const { name, age, city } = user;\n`;
    output += `name = ${name}, age = ${age}, city = ${city}\n`;
    
    // Методы Object
    output += "\n4. Методы Object:\n";
    output += `Object.keys(user): ${JSON.stringify(Object.keys(user))}\n`;
    output += `Object.values(user): ${JSON.stringify(Object.values(user))}\n`;
    output += `Object.entries(user): ${JSON.stringify(Object.entries(user))}`;

    outputToSection('output7', output);
}

// Запуск всех демонстраций
function runAllDemos() {
    demoSection1();
    setTimeout(() => demoSection2(), 300);
    setTimeout(() => demoSection3(), 600);
    setTimeout(() => demoSection4(), 900);
    setTimeout(() => demoSection5(), 1200);
    setTimeout(() => demoSection6(), 1500);
    setTimeout(() => demoAdditional(), 1800);
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    console.log("Демонстрация объектов JavaScript загружена!");
});