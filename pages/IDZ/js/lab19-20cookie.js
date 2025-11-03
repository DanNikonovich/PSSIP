(() => {
    "use strict";

    class FormCookieHandler {
        constructor() {
            this.cookieName = 'formUserData';
            this.init();
        }

        init() {
            this.bindEvents();
            this.loadDataFromCookie();
        }

        bindEvents() {
            // Обработка отправки формы
            document.addEventListener('click', (e) => {
                if (e.target.closest('.form-connect__button')) {
                    e.preventDefault();
                    this.handleFormSubmit(e.target.closest('.form-connect'));
                }
            });
        }

        // 1. Получить данные формы
        getFormData(form) {
            const formData = {};
            const fields = form.querySelectorAll('input, select, textarea');
            
            fields.forEach(field => {
                const fieldName = field.name || field.id || this.getFieldName(field);
                if (fieldName && fieldName !== 'undefined') {
                    formData[fieldName] = {
                        value: field.value.trim(),
                        type: field.type,
                        dataType: field.dataset.required || 'text',
                        label: this.getFieldLabel(field),
                        timestamp: new Date().toISOString()
                    };
                }
            });
            
            return formData;
        }

        getFieldName(field) {
            const label = field.previousElementSibling;
            if (label && label.tagName === 'LABEL') {
                return label.textContent.trim();
            }
            return field.placeholder || 'field_' + Date.now();
        }

        getFieldLabel(field) {
            const label = field.closest('label') || field.previousElementSibling;
            if (label && label.tagName === 'LABEL') {
                return label.textContent.trim().replace('*', '');
            }
            
            const placeholder = field.getAttribute('placeholder');
            if (placeholder) {
                return placeholder;
            }
            
            return field.name || field.id || 'Поле формы';
        }

        // Валидация формы
        validateForm(form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[data-required]');
            
            if (requiredFields.length === 0) {
                console.warn('В форме нет полей с атрибутом data-required');
                return false;
            }
            
            requiredFields.forEach(field => {
                if (!this.validateField(field)) {
                    isValid = false;
                }
            });
            
            return isValid;
        }

        validateField(field) {
            const value = field.value.trim();
            const type = field.dataset.required;
            
            // Проверка на пустое поле
            if (value === '') {
                this.addError(field, 'Це поле обов\'язкове для заповнення');
                return false;
            }
            
            // Проверка по типу
            switch(type) {
                case 'email':
                    if (!this.validateEmail(value)) {
                        this.addError(field, 'Введіть коректну email адресу');
                        return false;
                    }
                    break;
                    
                case 'tel':
                    if (!this.validatePhone(value)) {
                        this.addError(field, 'Введіть коректний номер телефону');
                        return false;
                    }
                    break;
                    
                case 'en|ru|ua':
                    if (!this.validateName(value)) {
                        this.addError(field, 'Тільки букви (англійські, російські, українські). Цифри не дозволені');
                        return false;
                    }
                    break;
            }
            
            this.removeError(field);
            return true;
        }

        // Валидационные функции
        validateEmail(email) {
            return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(email);
        }
        
        validatePhone(phone) {
            return /^[\+]?3?[\s]?8?[\s]?\(?0\d{2}?\)?[\s]?\d{3}[\s|-]?\d{2}[\s|-]?\d{2}$/.test(phone);
        }
        
        validateName(name) {
            // Исправленная валидация имени - только буквы
            return /^[a-zA-Zа-яА-ЯїЇіІєЄґҐ\s\-']+$/u.test(name);
        }

        addError(field, message = '') {
            field.classList.add('_form-error');
            field.parentElement.classList.add('_form-error');
            
            this.removeError(field);
            
            if (message) {
                const errorElement = document.createElement('div');
                errorElement.className = 'form-text-error';
                errorElement.textContent = message;
                errorElement.setAttribute('role', 'alert');
                field.parentElement.appendChild(errorElement);
            }
        }

        removeError(field) {
            field.classList.remove('_form-error');
            field.parentElement.classList.remove('_form-error');
            
            const errorElement = field.parentElement.querySelector('.form-text-error');
            if (errorElement) {
                errorElement.remove();
            }
        }

        // 2. Сохранить данные в Cookie
        saveDataToCookie(formData) {
            try {
                const dataString = JSON.stringify(formData);
                const expires = new Date();
                expires.setDate(expires.getDate() + 7); // Cookie на 7 дней
                
                document.cookie = `${this.cookieName}=${encodeURIComponent(dataString)}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
                console.log('Данные успешно сохранены в Cookie');
                return true;
            } catch (error) {
                console.error('Ошибка при сохранении в Cookie:', error);
                return false;
            }
        }

        // 3. Получить данные из Cookie
        getDataFromCookie() {
            try {
                const name = this.cookieName + "=";
                const decodedCookie = decodeURIComponent(document.cookie);
                const ca = decodedCookie.split(';');
                
                for(let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        const dataString = c.substring(name.length, c.length);
                        return JSON.parse(dataString);
                    }
                }
                return null;
            } catch (error) {
                console.error('Ошибка при чтении из Cookie:', error);
                return null;
            }
        }

        // 4. Очистить Cookie
        clearCookie() {
            try {
                document.cookie = `${this.cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
                console.log('Cookie успешно очищены');
                return true;
            } catch (error) {
                console.error('Ошибка при очистке Cookie:', error);
                return false;
            }
        }

        // Загрузить данные из Cookie в форму
        loadDataFromCookie() {
            const formData = this.getDataFromCookie();
            if (!formData) return;

            const form = document.querySelector('.form-connect');
            if (!form) return;

            Object.keys(formData).forEach(fieldName => {
                const fieldData = formData[fieldName];
                let field;
                
                // Поиск поля по разным атрибутам
                field = form.querySelector(`[name="${fieldName}"]`) || 
                        form.querySelector(`[id="${fieldName}"]`) ||
                        this.findFieldByLabel(form, fieldData.label);
                
                if (field && fieldData.value) {
                    field.value = fieldData.value;
                }
            });

            console.log('Данные из Cookie загружены в форму');
            this.showNotification('Данные из Cookie загружены в форму', 'success');
        }

        findFieldByLabel(form, label) {
            const labels = form.querySelectorAll('label');
            for (let labelElement of labels) {
                if (labelElement.textContent.trim().replace('*', '') === label) {
                    const fieldId = labelElement.getAttribute('for');
                    if (fieldId) {
                        return form.querySelector(`#${fieldId}`);
                    }
                }
            }
            return null;
        }

        // Обработчик отправки формы
        handleFormSubmit(form) {
            if (!this.validateForm(form)) {
                this.showNotification('Будь ласка, виправте помилки в формі', 'error');
                return;
            }

            // 1. Получить данные формы
            const formData = this.getFormData(form);
            console.log('Полученные данные формы:', formData);

            // 2. Сохранить в Cookie
            const saveResult = this.saveDataToCookie(formData);
            
            if (saveResult) {
                this.showNotification('Дані успішно збережено в Cookie', 'success');
                this.showFormData(formData);
            } else {
                this.showNotification('Помилка при збереженні в Cookie', 'error');
            }
        }

        // Показать данные формы
        showFormData(formData) {
            let message = 'Дані форми:\n\n';
            
            Object.keys(formData).forEach(key => {
                const field = formData[key];
                const value = field.value || '(не заповнено)';
                message += `${field.label}: ${value}\n`;
            });
            
            alert(message);
        }

        // Утилиты для работы с UI
        showNotification(message, type = 'info') {
            // Создаем уведомление
            const notification = document.createElement('div');
            notification.className = `form-notification form-notification--${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                z-index: 10000;
                max-width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.3s ease-out;
            `;

            if (type === 'success') {
                notification.style.background = '#28a745';
            } else if (type === 'error') {
                notification.style.background = '#dc3545';
            } else {
                notification.style.background = '#17a2b8';
            }

            document.body.appendChild(notification);

            // Автоматическое скрытие
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Публичные методы для внешнего использования
        saveFormData() {
            const form = document.querySelector('.form-connect');
            if (!form) {
                console.warn('Форма не найдена');
                return false;
            }
            
            const formData = this.getFormData(form);
            return this.saveDataToCookie(formData);
        }

        loadFormData() {
            return this.loadDataFromCookie();
        }

        clearFormData() {
            return this.clearCookie();
        }

        getStoredData() {
            return this.getDataFromCookie();
        }
    }

    // Добавляем CSS анимации
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .form-notification {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    `;
    document.head.appendChild(style);

    // Инициализация при загрузке DOM
    document.addEventListener('DOMContentLoaded', function() {
        window.formCookieHandler = new FormCookieHandler();
        console.log('Form Cookie Handler initialized');

        // Добавляем кнопки управления для тестирования
        addControlButtons();
    });

    // Функция для добавления тестовых кнопок
    function addControlButtons() {
        const controls = document.createElement('div');
        controls.className = 'cookie-controls';
        controls.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;

        const buttons = [
            { text: 'Загрузить из Cookie', action: () => window.formCookieHandler.loadFormData() },
            { text: 'Очистить Cookie', action: () => { 
                window.formCookieHandler.clearFormData(); 
                window.formCookieHandler.showNotification('Cookie очищены', 'success');
            }},
            { text: 'Показать сохраненные данные', action: () => {
                const data = window.formCookieHandler.getStoredData();
                if (data) {
                    window.formCookieHandler.showFormData(data);
                } else {
                    alert('В Cookie нет сохраненных данных');
                }
            }}
        ];

        buttons.forEach(btn => {
            const button = document.createElement('button');
            button.textContent = btn.text;
            button.style.cssText = `
                padding: 10px 15px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 12px;
            `;
            button.onclick = btn.action;
            controls.appendChild(button);
        });

        document.body.appendChild(controls);
    }

    // Экспорт для использования в других модулях
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = FormCookieHandler;
    }
})();