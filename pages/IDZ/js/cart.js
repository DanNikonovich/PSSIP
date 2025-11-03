class Cart {
    constructor() {
        this.items = this.loadCart();
        this.bindEvents();
        this.updateCartDisplay();
    }

    // Загрузить корзину из localStorage
    loadCart() {
        const savedCart = localStorage.getItem('hearingAidsCart');
        return savedCart ? JSON.parse(savedCart) : [];
    }

    // Сохранить корзину в localStorage
    saveCart() {
        localStorage.setItem('hearingAidsCart', JSON.stringify(this.items));
    }

    // Привязать события
    bindEvents() {
        document.addEventListener('click', (e) => {
            // Открытие/закрытие корзины - работает для любой иконки
            if (e.target.closest('.cart-toggle') || e.target.closest('.cart-icon')) {
                this.toggleCart();
            }
            // Добавление в корзину
            if (e.target.closest('.add-to-cart')) {
                const productId = parseInt(e.target.closest('.add-to-cart').dataset.productId);
                this.addToCart(productId);
            }
            
            // Удаление из корзины
            if (e.target.closest('.remove-from-cart')) {
                const productId = parseInt(e.target.closest('.remove-from-cart').dataset.productId);
                this.removeFromCart(productId);
            }
            
            // Открытие/закрытие корзины
            if (e.target.closest('.cart-toggle')) {
                this.toggleCart();
            }
        });

        // Обновление количества
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('cart-quantity')) {
                const productId = parseInt(e.target.dataset.productId);
                const quantity = parseInt(e.target.value);
                this.updateQuantity(productId, quantity);
            }
        });
    }

    // Добавить товар в корзину
    addToCart(productId) {
        const product = window.productCatalog.getProductById(productId);
        
        if (!product) {
            console.error('Товар не найден:', productId);
            return;
        }

        if (!product.inStock) {
            this.showMessage('Цей товар тимчасово відсутній', 'error');
            return;
        }

        const existingItem = this.items.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }

        this.saveCart();
        this.updateCartDisplay();
        this.showMessage('Товар додано до кошика', 'success');
        
        // Анимация добавления
        this.animateAddToCart(productId);
        // Анимация иконки корзины
        this.animateCartIcon();
    }

    // Анимация иконки корзины (универсальная)
    animateCartIcon() {
        const cartIcons = document.querySelectorAll('.cart-icon');
        cartIcons.forEach(icon => {
            icon.classList.add('added');
            setTimeout(() => {
                icon.classList.remove('added');
            }, 500);
        });
    }

    // Удалить товар из корзины
    removeFromCart(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveCart();
        this.updateCartDisplay();
        this.showMessage('Товар видалено з кошика', 'info');
    }

    // Обновить количество товара
    updateQuantity(productId, quantity) {
        if (quantity < 1) {
            this.removeFromCart(productId);
            return;
        }

        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity = quantity;
            this.saveCart();
            this.updateCartDisplay();
        }
    }

    // Получить общую стоимость
    getTotalPrice() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    // Получить общее количество товаров
    getTotalItems() {
        return this.items.reduce((total, item) => total + item.quantity, 0);
    }

    // Обновить отображение корзины
    updateCartDisplay() {
        this.updateCartIcon();
        this.updateCartModal();
    }

    updateCartIcon() {
        const cartCounts = document.querySelectorAll('.cart-count');
        const totalItems = this.getTotalItems();
        
        cartCounts.forEach(count => {
            count.textContent = totalItems;
            count.style.display = totalItems > 0 ? 'flex' : 'none';
        });
    }

    // Обновить модальное окно корзины
    updateCartModal() {
        const cartModal = document.getElementById('cart-modal');
        if (!cartModal) return;

        const itemsContainer = cartModal.querySelector('.cart-items');
        const totalElement = cartModal.querySelector('.cart-total');
        const emptyMessage = cartModal.querySelector('.cart-empty');
        const itemsList = cartModal.querySelector('.cart-items-list');

        if (this.items.length === 0) {
            emptyMessage.style.display = 'block';
            itemsList.style.display = 'none';
            totalElement.style.display = 'none';
        } else {
            emptyMessage.style.display = 'none';
            itemsList.style.display = 'block';
            totalElement.style.display = 'block';

            // Очистить и заполнить список товаров
            itemsList.innerHTML = '';
            this.items.forEach(item => {
                const itemElement = this.createCartItemElement(item);
                itemsList.appendChild(itemElement);
            });

            // Обновить итоговую сумму
            totalElement.querySelector('.total-price').textContent = 
                this.getTotalPrice().toFixed(2);
        }
    }

    // Создать элемент товара в корзине
    createCartItemElement(item) {
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="cart-item-image">
                <img src="${item.image}" alt="${item.name}" loading="lazy">
            </div>
            <div class="cart-item-details">
                <h4 class="cart-item-title">${item.name}</h4>
                <p class="cart-item-price">$${item.price.toFixed(2)}</p>
                <div class="cart-item-controls">
                    <button class="quantity-btn minus" data-product-id="${item.id}">-</button>
                    <input type="number" class="cart-quantity" 
                           data-product-id="${item.id}" 
                           value="${item.quantity}" min="1" max="99">
                    <button class="quantity-btn plus" data-product-id="${item.id}">+</button>
                    <button class="remove-from-cart" data-product-id="${item.id}">
                        🗑️
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Показать/скрыть корзину
    toggleCart() {
        const cartModal = document.getElementById('cart-modal');
        if (cartModal) {
            cartModal.classList.toggle('active');
            document.body.classList.toggle('cart-open');
        }
    }

    // Анимация добавления в корзину
    animateAddToCart(productId) {
        const productElement = document.querySelector(`[data-product-id="${productId}"]`);
        if (!productElement) return;

        const cartIcon = document.querySelector('.cart-toggle');
        if (!cartIcon) return;

        // Создаем летающий элемент
        const flyElement = document.createElement('div');
        flyElement.className = 'fly-to-cart';
        flyElement.innerHTML = '🛒';
        
        const productRect = productElement.getBoundingClientRect();
        const cartRect = cartIcon.getBoundingClientRect();
        
        flyElement.style.cssText = `
            position: fixed;
            left: ${productRect.left}px;
            top: ${productRect.top}px;
            font-size: 20px;
            z-index: 10000;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        `;
        
        document.body.appendChild(flyElement);
        
        // Запускаем анимацию
        setTimeout(() => {
            flyElement.style.left = `${cartRect.left}px`;
            flyElement.style.top = `${cartRect.top}px`;
            flyElement.style.opacity = '0';
            flyElement.style.transform = 'scale(0.5)';
        }, 50);
        
        // Удаляем элемент после анимации
        setTimeout(() => {
            document.body.removeChild(flyElement);
        }, 1000);
    }

    // Показать сообщение
    showMessage(text, type = 'info') {
        const message = document.createElement('div');
        message.className = `cart-message cart-message-${type}`;
        message.textContent = text;
        
        document.body.appendChild(message);
        
        setTimeout(() => {
            message.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            message.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(message);
            }, 300);
        }, 3000);
    }

    // Очистить корзину
    clearCart() {
        this.items = [];
        this.saveCart();
        this.updateCartDisplay();
        this.showMessage('Кошик очищено', 'info');
    }

    // Оформить заказ
    checkout() {
        if (this.items.length === 0) {
            this.showMessage('Кошик порожній', 'error');
            return;
        }

        const orderData = {
            items: this.items,
            total: this.getTotalPrice(),
            timestamp: new Date().toISOString(),
            orderId: 'ORD-' + Date.now()
        };

        // Здесь можно отправить данные на сервер
        console.log('Order data:', orderData);
        
        this.showMessage('Замовлення оформлено! Дякуємо!', 'success');
        this.clearCart();
        this.toggleCart();
    }
}