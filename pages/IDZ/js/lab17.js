// Главный класс приложения
class App {
    constructor() {
        this.init();
    }

    init() {
        // Инициализация всех модулей
        this.menu = new Menu();
        this.sliders = new Sliders();
        this.modals = new Modals();
        this.forms = new Forms();
        this.scroll = new ScrollHandler();
        this.masks = new InputMasks();
        this.animations = new Animations();
        
        // Общие события
        this.bindGlobalEvents();
    }

    bindGlobalEvents() {
        // Глобальные обработчики
        document.addEventListener('DOMContentLoaded', () => {
            this.onDOMReady();
        });
    }

    onDOMReady() {
        console.log('App initialized');
    }
}

// Модуль модальных окон
class Modals {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        // --------------------------СОБЫТИЕ МЫШИ--------------------------
        document.addEventListener('click', (e) => {
            this.handleClick(e);
        });

        // --------------------------СОБЫТИЕ КЛАВИАТУРЫ--------------------------
        document.addEventListener('keydown', (e) => {
            this.handleKeydown(e);
        });
    }

    handleClick(e) {
        const target = e.target;
        
        // Открытие модального окна
        if (target.closest('[data-modal]')) {
            const modalId = target.closest('[data-modal]').dataset.modal;
            this.openModal(modalId, target);
        }
        
        // Закрытие модального окна
        if (target.closest('._close-modal') || target.classList.contains('_modal-body')) {
            const modal = target.closest('._modal-wrapper');
            this.closeModal(modal);
        }
    }

    handleKeydown(e) {
        // Escape закрывает все модальные окна
        if (e.key === 'Escape') {
            this.closeAllModals();
        }
    }

    openModal(modalId, trigger) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        // Показать модальное окно
        modal.classList.add('_show-modal');
        document.body.classList.add('_lock');
        
        // Сохранить элемент, который вызвал открытие
        this.lastFocusedElement = trigger;
    }

    closeModal(modal) {
        modal.classList.remove('_show-modal');
        document.body.classList.remove('_lock');
        
        // Вернуть фокус на элемент, который открывал модальное окно
        if (this.lastFocusedElement) {
            this.lastFocusedElement.focus();
        }
    }

    closeAllModals() {
        document.querySelectorAll('._modal-wrapper').forEach(modal => {
            this.closeModal(modal);
        });
    }
}

// Модуль обработки прокрутки
// --------------------------СОБЫТИЕ ПРОКРУТКИ--------------------------
class ScrollHandler {
    constructor() {
        this.bindEvents();
        this.initScrollToTop();
    }

    bindEvents() {
        // События прокрутки
        document.addEventListener('scroll', () => {
            this.handleScroll();
        });

        // События мыши для кнопки "Наверх"
        // --------------------------СОБЫТИЕ МЫШИ--------------------------
        document.addEventListener('click', (e) => {
            if (e.target.closest('#scrollToTopBtn')) {
                this.scrollToTop();
            }
        });
    }

    handleScroll() {
        this.toggleScrollToTopButton();
    }

    initScrollToTop() {
        this.scrollToTopBtn = document.getElementById('scrollToTopBtn');
        this.scrollToTopImg = document.getElementById('scrollToTopImg');
        
        if (this.scrollToTopImg) {
            // Анимация при наведении
            this.scrollToTopImg.addEventListener('mouseenter', () => {
                this.rotateImage();
            });
        }
    }

    toggleScrollToTopButton() {
        if (!this.scrollToTopBtn) return;
        
        if (window.pageYOffset > 300) {
            this.scrollToTopBtn.style.display = 'block';
        } else {
            this.scrollToTopBtn.style.display = 'none';
        }
    }

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    rotateImage() {
        // Анимация вращения
        let start = null;
        const duration = 800;
        
        const animate = (time) => {
            if (!start) start = time;
            const elapsed = time - start;
            const progress = Math.min(elapsed / duration, 1);
            
            const angle = 360 * progress;
            this.scrollToTopImg.style.transform = `rotateY(${angle}deg)`;
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };
        
        requestAnimationFrame(animate);
    }
}

// Модуль анимаций
// --------------------------СОБЫТИЯ УКАЗАТЕЛЯ --------------------------
class Animations {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        // События мыши для анимаций
        document.addEventListener('mouseenter', (e) => {
            this.handleHover(e);
        });

        // События переходов
        document.addEventListener('transitionend', (e) => {
            this.handleTransitionEnd(e);
        });
    }

    handleHover(e) {
        // Анимации при наведении
        if (e.target.classList.contains('slide-products')) {
            this.animateProductCard(e.target);
        }
    }

    handleTransitionEnd(e) {
        // Обработка завершения CSS переходов
        if (e.target.classList.contains('_modal-content')) {
            console.log('Modal transition ended');
        }
    }

    animateProductCard(card) {
        // Анимация карточки товара
        card.style.transform = 'translateY(-5px)';
        card.style.transition = 'transform 0.3s ease';
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    }
}

//Модуль Drag & Drop
// --------------------------СОБЫТИЯ Drag & Drop --------------------------
class DragDrop {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        // События перетаскивания
        document.addEventListener('drop', (e) => {
            this.handleDrop(e);
        });

        document.addEventListener('dragover', (e) => {
            this.handleDragOver(e);
        });
    }

    handleDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        // Логика обработки перетаскивания файлов
    }

    handleDragOver(e) {
        e.preventDefault();
    }
}

// Инициализация приложения
const app = new App();

// Глобальные утилиты
window.app = app;

// Dynamic Adapt для адаптивного меню
class DynamicAdapt {
    // ... реализация DynamicAdapt
}

// Инициализация DynamicAdapt
const da = new DynamicAdapt("max");
da.init();