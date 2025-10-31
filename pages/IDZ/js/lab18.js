// Модуль форм - полная реализация валидации
class Forms {
    constructor() {
        this.bindEvents();
        this.initMasks();
    }

    bindEvents() {
        // Событие отправки формы
        document.addEventListener('submit', (e) => {
            this.handleSubmit(e);
        });

        // События фокуса
        document.addEventListener('focusin', (e) => {
            this.handleFocus(e);
        });

        // События потери фокуса
        document.addEventListener('focusout', (e) => {
            this.handleBlur(e);
        });

        // События ввода в реальном времени
        document.addEventListener('input', (e) => {
            this.handleInput(e);
        });

        // Обработка специальных кнопок формы
        document.addEventListener('click', (e) => {
            if (e.target.closest('.form-connect__button')) {
                e.preventDefault();
                this.handleFormButton(e.target.closest('.form-connect'));
            }
        });
    }

    // Обработка отправки формы
    handleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        
        if (this.validateForm(form)) {
            const formData = this.getFormData(form);
            this.showFormData(formData);
        } else {
            this.showValidationErrors(form);
        }
    }

    // Обработка кнопки формы
    handleFormButton(form) {
        if (this.validateForm(form)) {
            const formData = this.getFormData(form);
            this.showFormData(formData);
        } else {
            this.showValidationErrors(form);
        }
    }

    // Обработка фокуса на поле
    handleFocus(e) {
        if (e.target.hasAttribute('data-required')) {
            this.removeError(e.target);
        }
    }

    // Обработка потери фокуса
    handleBlur(e) {
        if (e.target.hasAttribute('data-required')) {
            this.validateField(e.target);
        }
    }

    // Обработка ввода в реальном времени
    handleInput(e) {
        if (e.target.hasAttribute('data-required')) {
            this.validateLength(e.target);
            this.validateField(e.target);
        }
    }

    // Получить все данные формы
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
                    label: this.getFieldLabel(field)
                };
            }
        });
        
        return formData;
    }

    // Получить имя поля
    getFieldName(field) {
        const label = field.previousElementSibling;
        if (label && label.tagName === 'LABEL') {
            return label.textContent.trim();
        }
        return field.placeholder || 'field_' + Date.now();
    }

    // Получить человеко-читаемое название поля
    // использование метода String: replace
    getFieldLabel(field) {
        const label = field.closest('label') || field.previousElementSibling;
        if (label && label.tagName === 'LABEL') {
            return label.textContent.trim().replace('*', '');
        }
        
        const placeholder = field.getAttribute('placeholder');
        if (placeholder) {
            return placeholder;
        }
        
        const dataLabel = field.getAttribute('data-label');
        if (dataLabel) {
            return dataLabel;
        }
        
        return field.name || field.id || 'Поле формы';
    }

    // Валидация всей формы
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

    // Валидация отдельного поля
    validateField(field) {
        const value = field.value.trim();
        const type = field.dataset.required;
        const maxLength = field.getAttribute('maxlength');
        const minLength = field.getAttribute('minlength');
        
        let isValid = true;
        
        // --------------------------ВАДИЖАЦИЯ НА ПУСТОЕ ПОЛЕ--------------------------
        if (value === '') {
            this.addError(field, 'Це поле обов\'язкове для заповнення');
            return false;
        }
        
        //  ПРОВЕРКА НА СООТВЕТСТВИЕ ФОРМАТУ (регулярные выражения)
        switch(type) {
            case 'email':
                isValid = this.validateEmail(value);
                if (!isValid) this.addError(field, 'Введіть коректну email адресу');
                break;
                
            case 'tel':
                isValid = this.validatePhone(value);
                if (!isValid) this.addError(field, 'Введіть коректний номер телефону');
                break;
                
            case 'en|ru|ua':
                isValid = this.validateName(value);
                if (!isValid) this.addError(field, 'Тільки букви (англійські, російські, українські). Цифри не дозволені');
                break;
                
            case 'num':
                isValid = this.validateNumber(value);
                if (!isValid) this.addError(field, 'Тільки цифри');
                break;
                
            case 'minmax':
                isValid = this.validateMinMax(value, 5, 10);
                if (!isValid) this.addError(field, 'Довжина повинна бути від 5 до 10 символів');
                break;
                
            case 'checkbox':
                isValid = field.checked;
                if (!isValid) this.addError(field, 'Це поле має бути відмічено');
                break;
                
            case 'file':
                isValid = field.value !== '';
                if (!isValid) this.addError(field, 'Виберіть файл');
                break;
                
            default:
                // Базовая проверка на пустоту
                isValid = value !== '';
                if (!isValid) this.addError(field, 'Це поле обов\'язкове для заповнення');
        }
        
        //  ОГРАНИЧЕНИЕ ПО ДЛИНЕ
        if (isValid) {
            if (maxLength && value.length > parseInt(maxLength)) {
                isValid = false;
                this.addError(field, `Максимальна довжина: ${maxLength} символів`);
            }
            
            if (minLength && value.length < parseInt(minLength)) {
                isValid = false;
                this.addError(field, `Мінімальна довжина: ${minLength} символів`);
            }
        }
        
        if (isValid) {
            this.removeError(field);
        }
        
        return isValid;
    }

    //  ПРОВЕРКА ДЛИНЫ В РЕАЛЬНОМ ВРЕМЕНИ
    validateLength(field) {
        const value = field.value;
        const maxLength = field.getAttribute('maxlength');
        
        if (maxLength && value.length > maxLength) {
            field.value = value.substring(0, maxLength);
        }
    }

    // --------------------------ВАДИЖАЦИЯ ЧЕРЕЗ РЕГУЛЯРНЫЕ ВЫРАЖЕНИЯ--------------------------
    // различные типы регулярных выражений
    // использование метода RegExp: test
    validateEmail(email) {
        return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(email);
    }
    
    validatePhone(phone) {
        // Украинские номера: +380, 380, 0xx, 80...
        return /^[\+]?3?[\s]?8?[\s]?\(?0\d{2}?\)?[\s]?\d{3}[\s|-]?\d{2}[\s|-]?\d{2}$/.test(phone);
    }
    
    validateName(name) {
        return /^[a-zA-Zа-яА-ЯёЁъЪыЫэЭїЇіІєЄґҐ\s\-']+$/u.test(name);
    }
    
    validateNumber(number) {
        return /^[0-9]*$/.test(number);
    }
    
    validateMinMax(value, min, max) {
        return value.length >= min && value.length <= max;
    }

    // Добавление ошибки
    addError(field, message = '') {
        field.classList.add('_form-error');
        field.parentElement.classList.add('_form-error');
        
        // Удаляем старую ошибку
        this.removeError(field);
        
        // Добавляем сообщение об ошибке
        if (message) {
            const errorElement = document.createElement('div');
            errorElement.className = 'form-text-error';
            errorElement.textContent = message;
            errorElement.setAttribute('role', 'alert');
            
            if (field.type === 'file') {
                field.closest('.file').appendChild(errorElement);
            } else {
                field.parentElement.appendChild(errorElement);
            }
        }
    }

    // Удаление ошибки
    removeError(field) {
        field.classList.remove('_form-error');
        field.parentElement.classList.remove('_form-error');
        
        let errorElement;
        if (field.type === 'file') {
            errorElement = field.closest('.file').querySelector('.form-text-error');
        } else {
            errorElement = field.parentElement.querySelector('.form-text-error');
        }
        
        if (errorElement) {
            errorElement.remove();
        }
    }

    // Показать данные формы в диалоговом окне
    showFormData(formData) {
        let message = ' Дані форми:\n\n';
        
        Object.keys(formData).forEach(key => {
            const field = formData[key];
            const value = field.value || '(не заповнено)';
            message += ` ${field.label}: ${value}\n`;
        });
        
        this.createCustomDialog('Дані форми', message);
    }

    // Показать ошибки валидации
    showValidationErrors(form) {
        const errorFields = form.querySelectorAll('._form-error');
        let errorMessage = '❌ Будь ласка, виправте наступні помилки:\n\n';
        
        errorFields.forEach((field, index) => {
            const fieldName = this.getFieldLabel(field);
            errorMessage += `${index + 1}. ${fieldName}\n`;
        });
        
        alert(errorMessage);
    }

    // Создать кастомное диалоговое окно
    createCustomDialog(title, message) {
        // Удаляем существующее окно если есть
        const existingDialog = document.getElementById('custom-form-dialog');
        if (existingDialog) {
            existingDialog.remove();
        }
        
        // Создаем диалоговое окно
        const dialog = document.createElement('div');
        dialog.id = 'custom-form-dialog';
        dialog.className = 'custom-dialog';
        dialog.innerHTML = `
            <div class="custom-dialog__overlay"></div>
            <div class="custom-dialog__content">
                <div class="custom-dialog__header">
                    <h3 class="custom-dialog__title">${title}</h3>
                    <button class="custom-dialog__close" aria-label="Закрити">×</button>
                </div>
                <div class="custom-dialog__body">
                    <pre class="custom-dialog__message">${message}</pre>
                </div>
                <div class="custom-dialog__footer">
                    <button class="custom-dialog__button custom-dialog__button--primary">OK</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(dialog);
        
        // Обработчики событий для диалога
        const closeBtn = dialog.querySelector('.custom-dialog__close');
        const okBtn = dialog.querySelector('.custom-dialog__button');
        const overlay = dialog.querySelector('.custom-dialog__overlay');
        
        const closeDialog = () => {
            dialog.remove();
        };
        
        closeBtn.addEventListener('click', closeDialog);
        okBtn.addEventListener('click', closeDialog);
        overlay.addEventListener('click', closeDialog);
        
        // Закрытие по Escape
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                closeDialog();
                document.removeEventListener('keydown', handleEscape);
            }
        };
        
        document.addEventListener('keydown', handleEscape);
    }

    // Инициализация масок ввода
    initMasks() {
        // Маска для телефона
        document.querySelectorAll('[data-mask="tel"]').forEach(input => {
            if (typeof IMask !== 'undefined') {
                IMask(input, { 
                    mask: '+{38}(000)000-00-00', 
                    lazy: false 
                });
            }
        });

        // Маска для числовых полей
        document.querySelectorAll('[data-mask="num-only"]').forEach(input => {
            if (typeof IMask !== 'undefined') {
                IMask(input, { 
                    mask: /^[0-9]{1,6}$/ 
                });
            }
        });

        // Базовая маска для email
        // использование метода String: split
        document.querySelectorAll('[data-required="email"]').forEach(input => {
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                // Автоматическое добавление @ если нужно
                if (value.includes('@') && !value.includes('@', value.indexOf('@') + 1)) {
                    const parts = value.split('@');
                    if (parts[1] && !parts[1].includes('.')) {
                        // Можно добавить подсказки для домена
                    }
                }
            });
        });
    }
}

// CSS стили для кастомного диалога и ошибок
const formStyles = `
.custom-dialog {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-dialog__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.custom-dialog__content {
    position: relative;
    background: white;
    border-radius: 12px;
    padding: 0;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: dialogAppear 0.3s ease-out;
}

@keyframes dialogAppear {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.custom-dialog__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px 0;
    margin-bottom: 16px;
}

.custom-dialog__title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c5aa0;
}

.custom-dialog__close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    padding: 4px;
    line-height: 1;
}

.custom-dialog__close:hover {
    color: #333;
}

.custom-dialog__body {
    padding: 0 24px;
    max-height: 50vh;
    overflow-y: auto;
}

.custom-dialog__message {
    white-space: pre-wrap;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.5;
    margin: 0;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.custom-dialog__footer {
    padding: 20px 24px;
    text-align: right;
    border-top: 1px solid #e9ecef;
    margin-top: 20px;
}

.custom-dialog__button {
    padding: 10px 24px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.custom-dialog__button--primary {
    background: #2c5aa0;
    color: white;
}

.custom-dialog__button--primary:hover {
    background: #1e3d6f;
}

/* Стили для ошибок формы */
._form-error {
    border-color: #dc3545 !important;
    background-color: #fff5f5 !important;
}

.form-text-error {
    color: #dc3545;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

/* Стили для валидных полей */
input:valid:not(:placeholder-shown) {
    border-color: #28a745 !important;
}

input:invalid:not(:placeholder-shown) {
    border-color: #dc3545 !important;
}
`;

// Добавляем стили в документ
if (document.head) {
    const styleSheet = document.createElement('style');
    styleSheet.textContent = formStyles;
    document.head.appendChild(styleSheet);
}

// Инициализация модуля форм при загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    window.formHandler = new Forms();
    console.log('Form handler initialized');
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Forms;
}