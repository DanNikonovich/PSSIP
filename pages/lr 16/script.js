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

// [Остальные демонстрационные функции остаются без изменений...]
// demoOOPvsProcedural(), demoClassVsObject() и т.д.

// ==================== ИНИЦИАЛИЗАЦИЯ ====================

document.addEventListener('DOMContentLoaded', function() {
    // Создаем экземпляр игры
    const game = Game.getInstance();
    
    // Запускаем первую демонстрацию
    demoOOPvsProcedural();
    
    console.log("🚀 Игра и демонстрация ООП загружены!");
    console.log("Управление: ← → для движения, ПРОБЕЛ для стрельбы");
});

// [Все демонстрационные функции из предыдущего кода...]