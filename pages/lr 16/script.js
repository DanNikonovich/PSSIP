// ==================== ИГРОВАЯ ЛОГИКА ====================

class Game {
    static #instance = null;
    
    constructor() {
        if (Game.#instance) {
            return Game.#instance;
        }
        Game.#instance = this;
        
        this.canvas = document.getElementById('gameCanvas');
        this.ctx = this.canvas.getContext('2d');
        this.score = 0;
        this.level = 1;
        this.isRunning = false;
        this.gameObjects = [];
        
        this.init();
    }

    static getInstance() {
        if (!Game.#instance) {
            Game.#instance = new Game();
        }
        return Game.#instance;
    }

    init() {
        this.player = new Player(this.canvas.width / 2 - 20, this.canvas.height - 60);
        this.gameObjects.push(this.player);
        this.setupEventListeners();
        this.updateGameInfo();
        this.render(); // Начальная отрисовка
    }

    setupEventListeners() {
        document.getElementById('startBtn').addEventListener('click', () => this.start());
        document.getElementById('pauseBtn').addEventListener('click', () => this.pause());
        document.getElementById('resetBtn').addEventListener('click', () => this.reset());
        
        // Управление клавиатурой
        this.keys = {};
        document.addEventListener('keydown', (e) => {
            this.keys[e.key] = true;
        });
        
        document.addEventListener('keyup', (e) => {
            this.keys[e.key] = false;
        });
    }

    handleInput() {
        if (this.keys['ArrowLeft']) {
            this.player.move(-8);
        }
        if (this.keys['ArrowRight']) {
            this.player.move(8);
        }
        if (this.keys[' '] || this.keys['Spacebar']) {
            this.player.shoot();
        }
    }

    start() {
        if (!this.isRunning) {
            this.isRunning = true;
            this.spawnInterval = setInterval(() => this.spawnEnemy(), 1500);
            this.gameLoop();
        }
    }

    pause() {
        this.isRunning = false;
        if (this.spawnInterval) {
            clearInterval(this.spawnInterval);
        }
    }

    reset() {
        this.pause();
        this.score = 0;
        this.level = 1;
        this.gameObjects = [this.player];
        this.player.health = 100;
        this.player.x = this.canvas.width / 2 - 20;
        this.updateGameInfo();
        this.render();
    }

    spawnEnemy() {
        if (!this.isRunning) return;
        
        const x = Math.random() * (this.canvas.width - 40);
        let enemy;
        
        // Разные типы врагов в зависимости от уровня
        const enemyType = Math.random();
        if (this.level >= 3 && enemyType < 0.2) {
            enemy = new TankEnemy(x, -40);
        } else if (this.level >= 2 && enemyType < 0.5) {
            enemy = new FastEnemy(x, -30);
        } else {
            enemy = new Enemy(x, -30);
        }
        
        this.gameObjects.push(enemy);
    }

    update() {
        if (!this.isRunning) return;

        this.handleInput();

        // Обновление всех игровых объектов
        for (let i = this.gameObjects.length - 1; i >= 0; i--) {
            const obj = this.gameObjects[i];
            obj.update();
            
            // Удаление вышедших за границы объектов или уничтоженных
            if (obj.y > this.canvas.height || obj.y < -50 || (obj.health !== undefined && obj.health <= 0)) {
                this.gameObjects.splice(i, 1);
            }
        }

        // Проверка коллизий
        this.checkCollisions();
        
        // Уровень сложности
        if (this.score >= this.level * 100) {
            this.level++;
        }
        
        this.updateGameInfo();
    }

    checkCollisions() {
        const bullets = this.gameObjects.filter(obj => obj instanceof Bullet && obj.friendly);
        const enemies = this.gameObjects.filter(obj => obj instanceof Enemy);

        for (let i = bullets.length - 1; i >= 0; i--) {
            const bullet = bullets[i];
            for (let j = enemies.length - 1; j >= 0; j--) {
                const enemy = enemies[j];
                if (this.isColliding(bullet, enemy)) {
                    enemy.takeDamage(bullet.damage);
                    if (enemy.health <= 0) {
                        this.score += enemy instanceof TankEnemy ? 30 : 
                                    enemy instanceof FastEnemy ? 15 : 10;
                        this.gameObjects.splice(this.gameObjects.indexOf(enemy), 1);
                    }
                    this.gameObjects.splice(this.gameObjects.indexOf(bullet), 1);
                    break;
                }
            }
        }

        // Проверка столкновений игрока с врагами
        for (let i = enemies.length - 1; i >= 0; i--) {
            const enemy = enemies[i];
            if (this.isColliding(this.player, enemy)) {
                this.player.takeDamage(20);
                this.gameObjects.splice(this.gameObjects.indexOf(enemy), 1);
                if (this.player.health <= 0) {
                    this.gameOver();
                }
            }
        }
    }

    isColliding(obj1, obj2) {
        return obj1.x < obj2.x + obj2.width &&
               obj1.x + obj1.width > obj2.x &&
               obj1.y < obj2.y + obj2.height &&
               obj1.y + obj1.height > obj2.y;
    }

    gameOver() {
        this.pause();
        alert(`Игра окончена! Ваш счет: ${this.score}`);
        this.reset();
    }

    render() {
        // Очистка canvas
        this.ctx.fillStyle = '#000011';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        // Звездный фон
        this.drawStars();

        // Отрисовка всех игровых объектов
        this.gameObjects.forEach(obj => obj.render(this.ctx));

        // Отрисовка HUD
        this.drawHUD();
    }

    drawStars() {
        if (!this.stars) {
            this.stars = [];
            for (let i = 0; i < 50; i++) {
                this.stars.push({
                    x: Math.random() * this.canvas.width,
                    y: Math.random() * this.canvas.height,
                    size: Math.random() * 2
                });
            }
        }

        this.ctx.fillStyle = '#ffffff';
        this.stars.forEach(star => {
            this.ctx.fillRect(star.x, star.y, star.size, star.size);
        });
    }

    drawHUD() {
        this.ctx.fillStyle = '#00ff88';
        this.ctx.font = '16px Arial';
        this.ctx.fillText(`Очки: ${this.score}`, 10, 25);
        this.ctx.fillText(`Уровень: ${this.level}`, 10, 45);
        
        // Полоска здоровья
        this.ctx.fillStyle = '#ff4444';
        this.ctx.fillRect(this.canvas.width - 120, 15, 100, 15);
        this.ctx.fillStyle = '#00ff88';
        this.ctx.fillRect(this.canvas.width - 120, 15, this.player.health, 15);
        this.ctx.fillStyle = '#ffffff';
        this.ctx.fillText('Здоровье', this.canvas.width - 120, 12);
    }

    gameLoop() {
        this.update();
        this.render();
        
        if (this.isRunning) {
            requestAnimationFrame(() => this.gameLoop());
        }
    }

    updateGameInfo() {
        document.getElementById('score').textContent = this.score;
        document.getElementById('level').textContent = this.level;
        document.getElementById('health').textContent = this.player.health;
    }
}

// ==================== БАЗОВЫЙ КЛАСС ИГРОВОГО ОБЪЕКТА ====================

class GameObject {
    constructor(x, y, width, height) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.speed = 0;
    }

    update() {
        this.y += this.speed;
    }

    render(ctx) {
        // Базовый метод отрисовки (прямоугольник)
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(this.x, this.y, this.width, this.height);
    }

    takeDamage(damage) {
        if (this.health !== undefined) {
            this.health -= damage;
        }
    }

    isAlive() {
        return this.health === undefined || this.health > 0;
    }
}

// ==================== КЛАСС ИГРОКА ====================

class Player extends GameObject {
    #color = '#00ff88';
    
    constructor(x, y) {
        super(x, y, 40, 40);
        this.health = 100;
        this._lastShot = 0;
        this.speed = 0;
    }

    move(direction) {
        this.x += direction;
        // Границы экрана
        this.x = Math.max(0, Math.min(this.x, 760));
    }

    shoot() {
        const now = Date.now();
        if (now - this._lastShot > 300) {
            const bullet = new Bullet(this.x + 15, this.y - 10, true);
            Game.getInstance().gameObjects.push(bullet);
            this._lastShot = now;
        }
    }

    render(ctx) {
        // Корпус корабля
        ctx.fillStyle = this.#color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
        
        // Носовая часть
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(this.x + 15, this.y - 10, 10, 10);
        
        // Двигатели
        ctx.fillStyle = '#ff6600';
        ctx.fillRect(this.x + 5, this.y + 40, 10, 5);
        ctx.fillRect(this.x + 25, this.y + 40, 10, 5);
    }

    get color() {
        return this.#color;
    }
}

// ==================== КЛАСС ПУЛИ ====================

class Bullet extends GameObject {
    constructor(x, y, friendly = false) {
        super(x, y, 4, 12);
        this.speed = friendly ? -8 : 6;
        this.friendly = friendly;
        this.damage = friendly ? 25 : 10;
        this.color = friendly ? '#00ffff' : '#ff4444';
    }

    render(ctx) {
        ctx.fillStyle = this.color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
        
        // Свечение пули
        ctx.fillStyle = this.friendly ? '#ffffff' : '#ff8888';
        ctx.fillRect(this.x + 1, this.y + 2, this.width - 2, this.height - 4);
    }
}

// ==================== КЛАСС ВРАГА ====================

class Enemy extends GameObject {
    static #totalEnemies = 0;
    
    constructor(x, y) {
        super(x, y, 30, 30);
        this.speed = 2;
        this.health = 50;
        this.color = '#ff4444';
        Enemy.#totalEnemies++;
    }

    render(ctx) {
        ctx.fillStyle = this.color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
        
        // "Глаза" врага
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(this.x + 5, this.y + 10, 5, 5);
        ctx.fillRect(this.x + 20, this.y + 10, 5, 5);
    }

    static getTotalEnemies() {
        return this.#totalEnemies;
    }
}

// ==================== СПЕЦИАЛИЗИРОВАННЫЕ КЛАССЫ ВРАГОВ ====================

class FastEnemy extends Enemy {
    constructor(x, y) {
        super(x, y);
        this.speed = 4;
        this.health = 30;
        this.width = 25;
        this.height = 25;
        this.color = '#ff6b6b';
    }

    render(ctx) {
        ctx.fillStyle = this.color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
        
        // Угловатая форма для быстрого врага
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(this.x + 8, this.y + 5, 3, 3);
        ctx.fillRect(this.x + 15, this.y + 5, 3, 3);
    }
}

class TankEnemy extends Enemy {
    constructor(x, y) {
        super(x, y);
        this.speed = 1;
        this.health = 100;
        this.width = 40;
        this.height = 40;
        this.color = '#8b0000';
    }

    render(ctx) {
        ctx.fillStyle = this.color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
        
        // Броня танка
        ctx.fillStyle = '#666666';
        ctx.fillRect(this.x + 5, this.y + 5, this.width - 10, 5);
        ctx.fillRect(this.x + 5, this.y + 15, this.width - 10, 5);
        ctx.fillRect(this.x + 5, this.y + 25, this.width - 10, 5);
    }
}

// ==================== ДЕМОНСТРАЦИОННЫЕ ФУНКЦИИ ====================

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

// 1. ООП vs Процедурное программирование
function demoOOPvsProcedural() {
    let output = "СРАВНЕНИЕ ПОДХОДОВ:\n\n";
    
    output += "ПРОЦЕДУРНЫЙ ПОДХОД:\n";
    output += "- Функции работают с данными\n";
    output += "- Данные передаются в функции\n";
    output += "- Сложно управлять состоянием\n";
    output += "- Трудно масштабировать\n\n";
    
    output += "ОБЪЕКТНО-ОРИЕНТИРОВАННЫЙ ПОДХОД:\n";
    output += "- Данные и методы объединены в объекты\n";
    output += "- Объекты управляют своим состоянием\n";
    output += "- Легко расширять через наследование\n";
    output += "- Упрощает поддержку и масштабирование\n\n";
    
    output += "В ИГРЕ: Каждый корабль, пуля, враг - объект со своими свойствами и поведением";

    outputToSection('output1', output);
}

// 2. Классы и объекты
function demoClassVsObject() {
    class Spaceship {
        constructor(name, speed) {
            this.name = name;
            this.speed = speed;
        }
        
        fly() {
            return `${this.name} летит со скоростью ${this.speed}`;
        }
    }

    const ship1 = new Spaceship("Аполлон", 1000);
    const ship2 = new Spaceship("Союз", 1200);
    
    let output = "КЛАСС Spaceship - это шаблон\n\n";
    output += "ОБЪЕКТЫ - экземпляры класса:\n";
    output += `ship1: ${JSON.stringify(ship1, null, 2)}\n`;
    output += `ship2: ${JSON.stringify(ship2, null, 2)}\n\n`;
    output += `ship1.fly(): ${ship1.fly()}\n`;
    output += `ship2.fly(): ${ship2.fly()}`;

    outputToSection('output2', output);
}

// 3. Синтаксис класса
function demoClassSyntax() {
    class GameEntity {
        // Конструктор
        constructor(name, x, y) {
            this.name = name;
            this.x = x;
            this.y = y;
            this.isActive = true;
        }

        // Методы
        move(dx, dy) {
            this.x += dx;
            this.y += dy;
            return `${this.name} переместился в (${this.x}, ${this.y})`;
        }

        deactivate() {
            this.isActive = false;
            return `${this.name} деактивирован`;
        }
    }

    const entity = new GameEntity("Ракета", 10, 20);
    
    let output = "СИНТАКСИС КЛАССА:\n\n";
    output += "class GameEntity {\n";
    output += "  constructor(name, x, y) { ... }\n";
    output += "  move(dx, dy) { ... }\n";
    output += "  deactivate() { ... }\n";
    output += "}\n\n";
    output += "Создание объекта:\n";
    output += `const entity = new GameEntity(\"Ракета\", 10, 20);\n\n`;
    output += `Результат:\n`;
    output += `entity.move(5, 3): ${entity.move(5, 3)}\n`;
    output += `entity.deactivate(): ${entity.deactivate()}\n`;
    output += `Состояние объекта: ${JSON.stringify(entity, null, 2)}`;

    outputToSection('output3', output);
}

// 4. Создание объектов
function demoObjectCreation() {
    class Character {
        constructor(name, type) {
            this.name = name;
            this.type = type;
        }
    }

    const characters = [
        new Character("Игрок", "Spaceship"),
        new Character("Враг 1", "Enemy"), 
        new Character("Враг 2", "FastEnemy"),
        new Character("Босс", "TankEnemy")
    ];

    let output = "СОЗДАНИЕ ОБЪЕКТОВ КЛАССА:\n\n";
    output += "Оператор new создает новый экземпляр:\n";
    output += "const obj = new ClassName(аргументы);\n\n";
    output += "Массив объектов:\n";
    
    characters.forEach((char, index) => {
        output += `${index + 1}. ${char.name} (${char.type})\n`;
    });

    outputToSection('output4', output);
}

// 5. Доступ к полям и методам
function demoFieldMethodAccess() {
    class Weapon {
        constructor(name, damage) {
            this.name = name;
            this.damage = damage;
            this.durability = 100;
        }

        attack() {
            this.durability -= 10;
            return `Оружие ${this.name} наносит ${this.damage} урона`;
        }

        repair() {
            this.durability = 100;
            return `${this.name} починено`;
        }
    }

    const laser = new Weapon("Лазер", 50);
    
    let output = "ДОСТУП К ПОЛЯМ И МЕТОДАМ:\n\n";
    output += "Доступ к полям (свойствам):\n";
    output += `laser.name = ${laser.name}\n`;
    output += `laser.damage = ${laser.damage}\n`;
    output += `laser.durability = ${laser.durability}\n\n`;
    
    output += "Вызов методов:\n";
    output += `laser.attack(): ${laser.attack()}\n`;
    output += `laser.durability после атаки = ${laser.durability}\n`;
    output += `laser.repair(): ${laser.repair()}\n`;
    output += `laser.durability после починки = ${laser.durability}`;

    outputToSection('output5', output);
}

// 6. Модификаторы доступа
function demoAccessModifiers() {
    class BankAccount {
        #pin = 1234;                    // приватное поле
        _balance = 0;                   // защищённое поле
        owner = "";                     // публичное поле

        constructor(owner, initialBalance) {
            this.owner = owner;
            this._balance = initialBalance;
        }

        // публичный метод
        withdraw(amount, pin) {
            if (this.#validatePin(pin)) {
                if (amount <= this._balance) {
                    this._balance -= amount;
                    return `Снято ${amount}. Баланс: ${this._balance}`;
                }
                return "Недостаточно средств";
            }
            return "Неверный PIN";
        }

        // приватный метод
        #validatePin(pin) {
            return pin === this.#pin;
        }

        // геттер для защищённого поля
        get balance() {
            return this._balance;
        }
    }

    const account = new BankAccount("Иван", 1000);
    
    let output = "МОДИФИКАТОРЫ ДОСТУПА:\n\n";
    output += "Публичные поля: доступны извне\n";
    output += `account.owner = ${account.owner}\n\n`;
    
    output += "Защищённые поля (соглашение _): не предназначены для прямого доступа\n";
    output += `account._balance = ${account._balance} (но лучше использовать геттер)\n`;
    output += `account.balance = ${account.balance} (через геттер)\n\n`;
    
    output += "Приватные поля (#): доступны только внутри класса\n";
    output += `account.#pin - ОШИБКА! Приватное поле недоступно\n\n`;
    
    output += "Использование методов:\n";
    output += `account.withdraw(100, 1234): ${account.withdraw(100, 1234)}\n`;
    output += `account.withdraw(100, 0000): ${account.withdraw(100, 0)}`;

    outputToSection('output6', output);
}

// 7. Статические поля и методы
function demoStatic() {
    class GameConfig {
        static #version = "1.0.0";          // приватное статическое поле
        static maxPlayers = 4;              // публичное статическое поле
        static #activePlayers = 0;          // приватное статическое поле

        constructor(playerName) {
            this.playerName = playerName;
            GameConfig.#activePlayers++;
        }

        // статический метод
        static getInfo() {
            return `Версия: ${this.#version}, Игроков: ${this.#activePlayers}/${this.maxPlayers}`;
        }

        static canJoin() {
            return this.#activePlayers < this.maxPlayers;
        }

        // статический геттер
        static get version() {
            return this.#version;
        }
    }

    let output = "СТАТИЧЕСКИЕ ПОЛЯ И МЕТОДЫ:\n\n";
    output += "Принадлежат классу, а не объектам:\n\n";
    
    output += "Доступ к статическим полям:\n";
    output += `GameConfig.maxPlayers = ${GameConfig.maxPlayers}\n`;
    output += `GameConfig.version = ${GameConfig.version}\n\n`;
    
    output += "Вызов статических методов:\n";
    output += `GameConfig.getInfo(): ${GameConfig.getInfo()}\n`;
    output += `GameConfig.canJoin(): ${GameConfig.canJoin()}\n\n`;
    
    output += "Создание объектов:\n";
    const player1 = new GameConfig("Игрок 1");
    output += `После создания player1: ${GameConfig.getInfo()}\n`;
    
    const player2 = new GameConfig("Игрок 2");
    const player3 = new GameConfig("Игрок 3");
    const player4 = new GameConfig("Игрок 4");
    output += `После создания 4 игроков: ${GameConfig.getInfo()}\n`;
    output += `Можно ли присоединиться?: ${GameConfig.canJoin()}`;

    outputToSection('output7', output);
}

// 8. Геттеры и сеттеры
function demoGettersSetters() {
    class Player {
        #health = 100;
        #maxHealth = 100;

        constructor(name) {
            this.name = name;
        }

        // геттер
        get health() {
            return this.#health;
        }

        // сеттер с валидацией
        set health(value) {
            if (value < 0) {
                this.#health = 0;
            } else if (value > this.#maxHealth) {
                this.#health = this.#maxHealth;
            } else {
                this.#health = value;
            }
        }

        get healthPercentage() {
            return (this.#health / this.#maxHealth) * 100;
        }

        takeDamage(damage) {
            this.health -= damage; // используем сеттер
            return `${this.name} получил ${damage} урона. Здоровье: ${this.health}`;
        }

        heal(amount) {
            this.health += amount; // используем сеттер
            return `${this.name} восстановил ${amount} здоровья. Здоровье: ${this.health}`;
        }
    }

    const player = new Player("Герой");
    
    let output = "ГЕТТЕРЫ И СЕТТЕРЫ:\n\n";
    output += "Геттеры (get) - для получения значений\n";
    output += "Сеттеры (set) - для установки значений с логикой\n\n";
    
    output += `player.health: ${player.health}\n`;
    output += `player.healthPercentage: ${player.healthPercentage}%\n\n`;
    
    output += "Использование сеттера через присваивание:\n";
    player.health = 150; // попытка установить больше максимума
    output += `player.health = 150 → ${player.health}\n`;
    
    player.health = -10; // попытка установить отрицательное значение
    output += `player.health = -10 → ${player.health}\n\n`;
    
    output += "Методы используют сеттер:\n";
    output += `${player.takeDamage(30)}\n`;
    output += `${player.heal(50)}\n`;
    output += `Текущее здоровье: ${player.health} (${player.healthPercentage}%)`;

    outputToSection('output8', output);
}

// 9. Принципы ООП
function demoOOPPrinciples() {
    let output = "БАЗОВЫЕ ПРИНЦИПЫ ООП:\n\n";
    
    output += "🎯 ИНКАПСУЛЯЦИЯ:\n";
    output += "Сокрытие внутренней реализации объекта\n";
    output += "Пример: Приватные поля #health, публичные методы attack()\n";
    output += "Польза: Защита данных, упрощение использования\n\n";
    
    output += "🔄 НАСЛЕДОВАНИЕ:\n";
    output += "Создание новых классов на основе существующих\n";
    output += "Пример: FastEnemy и TankEnemy наследуются от Enemy\n";
    output += "Польза: Повторное использование кода, иерархия классов\n\n";
    
    output += "🎭 ПОЛИМОРФИЗМ:\n";
    output += "Одинаковые методы работают по-разному в разных классах\n";
    output += "Пример: Метод render() по-разному отрисовывает разные объекты\n";
    output += "Польза: Гибкость, расширяемость, единый интерфейс\n\n";
    
    output += "В ИГРЕ:\n";
    output += "- Инкапсуляция: Внутреннее состояние объектов скрыто\n";
    output += "- Наследование: Иерархия GameObject → Player/Enemy/Bullet\n";
    output += "- Полиморфизм: Все объекты имеют update() и render()";

    outputToSection('output9', output);
}

// 10. Реализация в игре
function demoImplementation() {
    let output = "РЕАЛИЗАЦИЯ ПРИНЦИПОВ ООП В ИГРЕ:\n\n";
    
    output += "📁 СТРУКТУРА КЛАССОВ:\n";
    output += "GameObject (базовый класс)\n";
    output += "  ├── Player\n";
    output += "  ├── Enemy\n";
    output += "  │   ├── FastEnemy\n";
    output += "  │   └── TankEnemy\n";
    output += "  └── Bullet\n\n";
    
    output += "🔒 ИНКАПСУЛЯЦИЯ В ДЕЙСТВИИ:\n";
    output += "class Player {\n";
    output += "  #color = '#00ff88';        // приватное поле\n";
    output += "  _lastShot = 0;             // защищённое поле\n";
    output += "  \n";
    output += "  shoot() {                   // публичный метод\n";
    output += "    // внутренняя логика скрыта\n";
    output += "  }\n";
    output += "}\n\n";
    
    output += "🔄 НАСЛЕДОВАНИЕ В ДЕЙСТВИИ:\n";
    output += "class Enemy extends GameObject {\n";
    output += "  // наследует x, y, health, update(), render()\n";
    output += "  // добавляет свою специфическую логику\n";
    output += "}\n\n";
    
    output += "class FastEnemy extends Enemy {\n";
    output += "  // переопределяет скорость и здоровье\n";
    output += "  // может переопределить render()\n";
    output += "}\n\n";
    
    output += "🎭 ПОЛИМОРФИЗМ В ДЕЙСТВИИ:\n";
    output += "// Все объекты в массиве gameObjects\n";
    output += "gameObjects.forEach(obj => {\n";
    output += "  obj.update();  // каждый объект обновляется по-своему\n";
    output += "  obj.render();  // каждый объект отрисовывается по-своему\n";
    output += "});\n\n";
    
    output += "⚡ ПАТТЕРН СИНГЛТОН:\n";
    output += "class Game {\n";
    output += "  static #instance = null;\n";
    output += "  \n";
    output += "  static getInstance() {\n";
    output += "    if (!Game.#instance) {\n";
    output += "      Game.#instance = new Game();\n";
    output += "    }\n";
    output += "    return Game.#instance;\n";
    output += "  }\n";
    output += "}";

    outputToSection('output10', output);
}

// Запуск всех демонстраций
function runAllDemos() {
    demoOOPvsProcedural();
    setTimeout(() => demoClassVsObject(), 300);
    setTimeout(() => demoClassSyntax(), 600);
    setTimeout(() => demoObjectCreation(), 900);
    setTimeout(() => demoFieldMethodAccess(), 1200);
    setTimeout(() => demoAccessModifiers(), 1500);
    setTimeout(() => demoStatic(), 1800);
    setTimeout(() => demoGettersSetters(), 2100);
    setTimeout(() => demoOOPPrinciples(), 2400);
    setTimeout(() => demoImplementation(), 2700);
}

// Инициализация игры при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    const game = Game.getInstance();
    console.log("Игра и демонстрация ООП загружены!");
});