class ProductCatalog {
    constructor() {
        this.products = [];
        this.filteredProducts = [];
        this.currentCategory = 'all';
        this.init();
    }

    async init() {
        await this.loadProducts();
        this.renderProducts();
        this.bindEvents();
    }

    // Загрузить товары из JSON
    async loadProducts() {
        try {
            const response = await fetch('./data/products.json');
            const data = await response.json();
            this.products = data.products;
            this.filteredProducts = [...this.products];
        } catch (error) {
            console.error('Error loading products:', error);
            // Fallback данные
            this.products = [];
            this.filteredProducts = [];
        }
    }

    // Привязать события
    bindEvents() {
        // Фильтрация по категориям
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-tab-caption]')) {
                const category = e.target.closest('[data-tab-caption]').dataset.tabCaption;
                this.filterByCategory(category);
            }
        });

        // Поиск товаров
        const searchInput = document.querySelector('.products-search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchProducts(e.target.value);
            });
        }

        // Сортировка
        const sortSelect = document.querySelector('.products-sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.sortProducts(e.target.value);
            });
        }
    }

    // Фильтрация по категории
    filterByCategory(category) {
        this.currentCategory = category;
        
        if (category === 'all') {
            this.filteredProducts = [...this.products];
        } else {
            this.filteredProducts = this.products.filter(
                product => product.category === category
            );
        }
        
        this.renderProducts();
    }

    // Поиск товаров
    searchProducts(query) {
        if (!query.trim()) {
            this.filteredProducts = [...this.products];
        } else {
            const lowerQuery = query.toLowerCase();
            this.filteredProducts = this.products.filter(product =>
                product.name.toLowerCase().includes(lowerQuery) ||
                product.description.toLowerCase().includes(lowerQuery)
            );
        }
        
        this.renderProducts();
    }

    // Сортировка товаров
    sortProducts(criteria) {
        switch(criteria) {
            case 'price-asc':
                this.filteredProducts.sort((a, b) => a.price - b.price);
                break;
            case 'price-desc':
                this.filteredProducts.sort((a, b) => b.price - a.price);
                break;
            case 'name-asc':
                this.filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case 'name-desc':
                this.filteredProducts.sort((a, b) => b.name.localeCompare(a.name));
                break;
            case 'discount':
                this.filteredProducts.sort((a, b) => (b.discount || 0) - (a.discount || 0));
                break;
            default:
                // По умолчанию - оригинальный порядок
                this.filteredProducts = [...this.filteredProducts];
        }
        
        this.renderProducts();
    }

    // Отобразить товары
renderProducts() {
    // Очищаем все контейнеры
    const containers = {
        'all': document.querySelector('[data-tab-content="all"] .slider-products__wrapper'),
        'aids': document.querySelector('[data-tab-content="aids"] .slider-products__wrapper'),
        'accessory': document.querySelector('[data-tab-content="accessory"] .slider-products__wrapper')
    };

    // Очищаем все контейнеры
    Object.values(containers).forEach(container => {
        if (container) container.innerHTML = '';
    });

    if (this.filteredProducts.length === 0) {
        const emptyMessage = `
            <div class="products-empty">
                <p>Товари не знайдено</p>
            </div>
        `;
        Object.values(containers).forEach(container => {
            if (container) container.innerHTML = emptyMessage;
        });
        return;
    }

    // Заполняем контейнеры товарами
    this.filteredProducts.forEach(product => {
        const productElement = this.createProductElement(product);
        
        // Добавляем в соответствующий контейнер категории
        if (containers['all']) {
            containers['all'].appendChild(productElement.cloneNode(true));
        }
        
        if (product.category === 'aids' && containers['aids']) {
            containers['aids'].appendChild(productElement.cloneNode(true));
        }
        
        if (product.category === 'accessory' && containers['accessory']) {
            containers['accessory'].appendChild(productElement.cloneNode(true));
        }
    });

    // Инициализируем Swiper для активной вкладки
    this.initSwiper();
}

    // Создать элемент товара
    createProductElement(product) {
        const div = document.createElement('div');
        div.className = 'slider-products__slide slide-products _animated';
        div.innerHTML = `
            <div class="slide-products__inner">
                <div class="slide-products__header">
                    <a href="#" class="slide-products__image _imw" 
                       data-modal="modal-product" 
                       data-product-id="${product.id}">
                        <img src="${product.image}" alt="${product.name}" loading="lazy">
                        ${!product.inStock ? '<div class="out-of-stock">Немає в наявності</div>' : ''}
                    </a>
                </div>
                <div class="slide-products__body">
                    <h3 class="slide-products__title">${product.name}</h3>
                    <ul class="slide-products__list">
                        <li class="slide-products__item">Частотний діапазон, Гц: 
                            <span>${product.features.frequency}</span>
                        </li>
                        <li class="slide-products__item">Макс підсилення, дБ: 
                            <span>${product.features.amplification}</span>
                        </li>
                        <li class="slide-products__item">Тип корпусу:
                            <span>${product.features.caseType}</span>
                        </li>
                    </ul>
                </div>
                <div class="slide-products__footer">
                    <div class="slide-products__price price-product">
                        <div class="price-product__old">
                            <p class="price-product__old-value">$${product.oldPrice.toFixed(2)}</p>
                            <p class="price-product__sale">-${product.discount}%</p>
                        </div>
                        <p class="price-product__new">$${product.price.toFixed(2)}</p>
                    </div>
                    <button class="slide-products__button button button_primary add-to-cart" 
                            data-product-id="${product.id}"
                            ${!product.inStock ? 'disabled' : ''}>
                        <svg class="icon-phone-fill">
                            <use href="./sprites/sprite.svg#icon-phone-fill"></use>
                        </svg>
                        ${product.inStock ? 'Додати до кошика' : 'Немає в наявності'}
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Инициализировать Swiper
    initSwiper() {
        if (typeof Swiper !== 'undefined' && document.querySelector('.slider-products')) {
            new Swiper('.slider-products', {
                // конфигурация Swiper...
            });
        }
    }

    // Получить товар по ID
    getProductById(id) {
        return this.products.find(product => product.id === id);
    }

    // Получить товары по категории
    getProductsByCategory(category) {
        return this.products.filter(product => product.category === category);
    }
}