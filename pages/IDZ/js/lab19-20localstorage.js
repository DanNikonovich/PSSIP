(() => {
    "use strict";

    class FormLocalStorageHandler {
        constructor() {
            this.storageKey = 'formUserData';
            this.init();
        }

        init() {
            this.bindEvents();
            this.loadDataFromStorage();
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
            const formData = {
                _metadata: {
                    savedAt: new Date().toISOString(),
                    version: '1.0'
                }
            };
            
            const fields = form.querySelectorAll('input, select, textarea');
            
            fields.forEach(field => {
                const fieldName = field.name || field.id || this.getFieldName(field);
                if (fieldName && fieldName !== 'undefined') {
                    formData[fieldName] = {
                        value: field.value.trim(),
                        type: field.type,
                        dataType: field.dataset.required || 'text',
                        label: this.getFieldLabel(field),
                        placeholder: field.getAttribute('placeholder') || '',
                        timestamp: new Date().toISOString()
                    };
                }
            });
            
            return formData;
        }

        getFieldName(field) {
            const label = field.previousElementSibling;
            if (label && label.tagName === 'LABEL') {
                return this.sanitizeKey(label.textContent.trim());
            }
            return this.sanitizeKey(field.placeholder || 'field_' + Date.now());
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

        // Санитизация ключей для хранения
        sanitizeKey(key) {
            return key.replace(/[^a-zA-Z0-9а-яА-ЯїЇіІєЄґҐ_\-\s]/g, '').replace(/\s+/g, '_');
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

        // 2. Сохранить данные в Local Storage
        saveDataToStorage(formData) {
            try {
                // Получаем существующие данные (для истории)
                const existingData = this.getDataFromStorage();
                const storageData = {
                    current: formData,
                    history: existingData?.history || [],
                    lastUpdated: new Date().toISOString()
                };

                // Добавляем в историю (сохраняем последние 10 версий)
                if (existingData?.current) {
                    storageData.history.unshift({
                        ...existingData.current,
                        savedAt: existingData.lastUpdated
                    });
                    
                    if (storageData.history.length > 10) {
                        storageData.history = storageData.history.slice(0, 10);
                    }
                }

                const dataString = JSON.stringify(storageData);
                localStorage.setItem(this.storageKey, dataString);

                this.refreshDevTools();
                
                console.log('Данные успешно сохранены в Local Storage');
                console.log('Размер данных:', new Blob([dataString]).size, 'bytes');
                
                return true;
            } catch (error) {
                console.error('Ошибка при сохранении в Local Storage:', error);
                
                // Проверяем, не превышен ли лимит
                if (error.name === 'QuotaExceededError') {
                    this.showNotification('Перевищено ліміт сховища. Спробуйте видалити старі дані.', 'error');
                }
                
                return false;
            }
        }

        // 3. Получить данные из Local Storage
        getDataFromStorage() {
            try {
                const dataString = localStorage.getItem(this.storageKey);
                if (!dataString) return null;
                
                const data = JSON.parse(dataString);
                return data;
            } catch (error) {
                console.error('Ошибка при чтении из Local Storage:', error);
                return null;
            }
        }

        // Получить только текущие данные
        getCurrentData() {
            const storageData = this.getDataFromStorage();
            return storageData?.current || null;
        }

        // Получить историю изменений
        getHistoryData() {
            const storageData = this.getDataFromStorage();
            return storageData?.history || [];
        }

        // 4. Очистить Local Storage
        clearStorage() {
            try {
                localStorage.removeItem(this.storageKey);
                console.log('Данные успешно удалены из Local Storage');
                return true;
            } catch (error) {
                console.error('Ошибка при удалении из Local Storage:', error);
                return false;
            }
        }

        // Очистить всю историю
        clearAllData() {
            try {
                localStorage.clear();
                console.log('Все данные удалены из Local Storage');
                return true;
            } catch (error) {
                console.error('Ошибка при полной очистке Local Storage:', error);
                return false;
            }
        }

        // Загрузить данные из Local Storage в форму
        loadDataFromStorage() {
            const formData = this.getCurrentData();
            if (!formData) {
                console.log('В Local Storage нет сохраненных данных');
                return;
            }

            const form = document.querySelector('.form-connect');
            if (!form) {
                console.warn('Форма не найдена');
                return;
            }

            let loadedFields = 0;
            Object.keys(formData).forEach(fieldName => {
                // Пропускаем метаданные
                if (fieldName.startsWith('_')) return;
                
                const fieldData = formData[fieldName];
                let field;
                
                // Поиск поля по разным атрибутам
                field = form.querySelector(`[name="${fieldName}"]`) || 
                        form.querySelector(`[id="${fieldName}"]`) ||
                        this.findFieldByLabel(form, fieldData.label);
                
                if (field && fieldData.value) {
                    field.value = fieldData.value;
                    loadedFields++;
                }
            });

            if (loadedFields > 0) {
                console.log(`Загружено ${loadedFields} полей из Local Storage`);
                this.showNotification(`Завантажено ${loadedFields} полів з Local Storage`, 'success');
                
                // Показываем информацию о времени сохранения
                if (formData._metadata?.savedAt) {
                    const savedDate = new Date(formData._metadata.savedAt);
                    console.log('Данные сохранены:', savedDate.toLocaleString());
                }
            }
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

            // 2. Сохранить в Local Storage
            const saveResult = this.saveDataToStorage(formData);
            
            if (saveResult) {
                this.showNotification('Дані успішно збережено в Local Storage', 'success');
                this.showFormData(formData);
                
                // Показываем статистику хранилища
                this.showStorageInfo();
            } else {
                this.showNotification('Помилка при збереженні в Local Storage', 'error');
            }
        }

        // Показать данные формы
        showFormData(formData) {
            let message = 'Дані форми:\n\n';
            
            Object.keys(formData).forEach(key => {
                if (key.startsWith('_')) return;
                
                const field = formData[key];
                const value = field.value || '(не заповнено)';
                message += `🏷️ ${field.label}: ${value}\n`;
            });
            
            // Добавляем метаданные
            if (formData._metadata?.savedAt) {
                const savedDate = new Date(formData._metadata.savedAt);
                message += `\n💾 Збережено: ${savedDate.toLocaleString()}`;
            }
            
            alert(message);
        }

        // Показать информацию о хранилище
        showStorageInfo() {
            try {
                const storageData = this.getDataFromStorage();
                if (!storageData) return;

                const currentData = storageData.current;
                const historyCount = storageData.history?.length || 0;
                
                let infoMessage = '📊 Інформація про сховище:\n\n';
                infoMessage += `💾 Поточні дані: ${Object.keys(currentData).filter(k => !k.startsWith('_')).length} полів\n`;
                infoMessage += `📚 Версій в історії: ${historyCount}\n`;
                infoMessage += `🕐 Останнє оновлення: ${new Date(storageData.lastUpdated).toLocaleString()}\n`;
                
                // Расчет размера данных
                const dataSize = new Blob([JSON.stringify(storageData)]).size;
                infoMessage += `📏 Розмір даних: ${(dataSize / 1024).toFixed(2)} KB\n`;
                
                // Лимит хранилища
                const maxSize = 5 * 1024 * 1024; // 5MB
                const usedPercentage = (dataSize / maxSize * 100).toFixed(1);
                infoMessage += `📈 Використано: ${usedPercentage}% від ліміту\n`;
                
                console.log(infoMessage);
                
            } catch (error) {
                console.error('Ошибка при получении информации о хранилище:', error);
            }
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
                max-width: 350px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.3s ease-out;
                font-family: Arial, sans-serif;
                font-size: 14px;
            `;

            if (type === 'success') {
                notification.style.background = '#28a745';
            } else if (type === 'error') {
                notification.style.background = '#dc3545';
            } else if (type === 'warning') {
                notification.style.background = '#ffc107';
                notification.style.color = '#212529';
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
            }, 5000);
        }

        // Публичные методы для внешнего использования
        saveFormData() {
            const form = document.querySelector('.form-connect');
            if (!form) {
                console.warn('Форма не найдена');
                return false;
            }
            
            const formData = this.getFormData(form);
            return this.saveDataToStorage(formData);
        }

        loadFormData() {
            return this.loadDataFromStorage();
        }

        clearFormData() {
            return this.clearStorage();
        }

        clearAllData() {
            return this.clearAllData();
        }

        getStoredData() {
            return this.getCurrentData();
        }

        getStorageInfo() {
            return this.showStorageInfo();
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
        
        .storage-controls {
            font-family: Arial, sans-serif;
        }
        
        .storage-controls button {
            transition: all 0.3s ease;
        }
        
        .storage-controls button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
    `;
    document.head.appendChild(style);

    // Инициализация при загрузке DOM
    document.addEventListener('DOMContentLoaded', function() {
        window.formStorageHandler = new FormLocalStorageHandler();
        console.log('Form Local Storage Handler initialized');

        // Добавляем кнопки управления для тестирования
        addStorageControlButtons();
    });

    // Функция для добавления тестовых кнопок
    function addStorageControlButtons() {
        const controls = document.createElement('div');
        controls.className = 'storage-controls';
        controls.style.cssText = `
            position: fixed;
            bottom: 150px;
            left: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: rgba(255,255,255,0.95);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        `;

        const buttons = [
            { 
                text: '💾 Загрузить из Storage', 
                action: () => window.formStorageHandler.loadFormData(),
                color: '#17a2b8'
            },
            { 
                text: '👁️ Показать данные', 
                action: () => {
                    const data = window.formStorageHandler.getStoredData();
                    if (data) {
                        window.formStorageHandler.showFormData(data);
                    } else {
                        alert('В Local Storage нет сохраненных данных');
                    }
                },
                color: '#20c997'
            },
            { 
                text: '💥 Очистить всё', 
                action: () => { 
                    if (confirm('Видалити ВСІ дані з Local Storage?')) {
                        window.formStorageHandler.clearAllData(); 
                        window.formStorageHandler.showNotification('Всі дані очищені', 'warning');
                    }
                },
                color: '#dc3545'
            }
        ];

        // Заголовок панели
        const title = document.createElement('div');
        title.textContent = 'Local Storage Controls';
        title.style.cssText = `
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            font-size: 14px;
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        `;
        controls.appendChild(title);

        buttons.forEach(btn => {
            const button = document.createElement('button');
            button.textContent = btn.text;
            button.style.cssText = `
                padding: 10px 15px;
                background: ${btn.color};
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 12px;
                min-width: 180px;
            `;
            button.onclick = btn.action;
            controls.appendChild(button);
        });

        document.body.appendChild(controls);
    }

    // Экспорт для использования в других модулях
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = FormLocalStorageHandler;
    }
})();