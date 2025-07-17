// Email validation JavaScript for real-time checking
document.addEventListener('DOMContentLoaded', function() {
    const emailFields = ['email', 'email_kilang'];
    
    emailFields.forEach(fieldName => {
        const emailField = document.querySelector(`input[name="${fieldName}"]`);
        if (emailField) {
            let timeout;
            
            emailField.addEventListener('input', function() {
                clearTimeout(timeout);
                const email = this.value.trim();
                
                if (email && isValidEmail(email)) {
                    timeout = setTimeout(() => {
                        checkEmailValidation(email, fieldName);
                    }, 500); // Debounce for 500ms
                } else if (email) {
                    // Clear validation states for invalid email format
                    clearEmailValidation(fieldName);
                }
            });
        }
    });
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function checkEmailValidation(email, fieldName) {
        // Clear existing validation states
        clearEmailValidation(fieldName);
        
        // Check if emails are different from each other
        const otherFieldName = fieldName === 'email' ? 'email_kilang' : 'email';
        const otherField = document.querySelector(`input[name="${otherFieldName}"]`);
        
        if (otherField && otherField.value.trim()) {
            const otherEmail = otherField.value.trim().toLowerCase();
            const currentEmail = email.toLowerCase();
            
            if (currentEmail === otherEmail) {
                showEmailError(fieldName, 'Email pengguna dan email kilang mesti berbeza. Sila gunakan alamat email yang berbeza.');
                document.querySelector(`input[name="${fieldName}"]`).classList.add('is-invalid');
                return; // Don't proceed with uniqueness check
            }
        }
        
        // Check uniqueness across all tables
        checkEmailUniqueness(email, fieldName);
    }
    
    function checkEmailUniqueness(email, fieldName) {
        // Create AJAX request
        fetch('/check-email-uniqueness', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: email,
                field: fieldName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.unique) {
                showEmailError(fieldName, 'Email ini telah digunakan dalam sistem. Sila pilih email yang lain.');
                document.querySelector(`input[name="${fieldName}"]`).classList.add('is-invalid');
            } else {
                document.querySelector(`input[name="${fieldName}"]`).classList.remove('is-invalid');
                document.querySelector(`input[name="${fieldName}"]`).classList.add('is-valid');
            }
        })
        .catch(error => {
            console.error('Error checking email uniqueness:', error);
        });
    }
    
    function showEmailError(fieldName, message) {
        const inputField = document.querySelector(`input[name="${fieldName}"]`);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger email-validation-error';
        errorDiv.innerHTML = `<strong>${message}</strong>`;
        
        inputField.parentElement.appendChild(errorDiv);
    }
    
    function clearEmailValidation(fieldName) {
        const inputField = document.querySelector(`input[name="${fieldName}"]`);
        const errorDiv = inputField.parentElement.querySelector('.email-validation-error');
        
        // Remove existing error message
        if (errorDiv) {
            errorDiv.remove();
        }
        
        // Clear validation classes
        inputField.classList.remove('is-invalid', 'is-valid');
    }
});
