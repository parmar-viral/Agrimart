document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("loginForm");

    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");

    const usernameError = document.getElementById("usernameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    let touchedFields = {};

    function validateField(field, validationFunction, errorElement) {
        if (!validationFunction()) {
            field.classList.add("invalid");
            errorElement.style.display = "block";
            return false;
        } else {
            field.classList.remove("invalid");
            errorElement.style.display = "none";
            return true;
        }
    }

    function addValidationListeners(field, validationFunction, errorElement) {
        field.addEventListener("blur", function(event) {
            if (touchedFields[field.id]) {
                validateField(field, validationFunction, errorElement);
            }
        });

        field.addEventListener("focus", function(event) {
            touchedFields[field.id] = true;
            clearError(field, errorElement);
        });

        field.addEventListener("input", function(event) {
            if (touchedFields[field.id]) {
                validateField(field, validationFunction, errorElement);
            }
        });
    }

    addValidationListeners(username, validateUsername, usernameError);
    addValidationListeners(email, validateEmail, emailError);
    addValidationListeners(password, validatePassword, passwordError);

    form.addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    function validateUsername() {
        const usernamePattern = /^[a-zA-Z0-9]{3,15}$/;
        if (!usernamePattern.test(username.value)) {
            usernameError.textContent = "Username must be 3-15 characters long and contain only alphanumeric characters.";
            return false;
        } else {
            usernameError.textContent = "";
            return true;
        }
    }

    function validateEmail() {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email.value)) {
            emailError.textContent = "Please enter a valid email address.";
            return false;
        } else {
            emailError.textContent = "";
            return true;
        }
    }

    function validatePassword() {
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
        // Check password length
        if (password.length < 6) {
            passwordError.textContent = "Password must be at least 6 characters long.";
            return false;
        }
        // Check if the password matches the pattern
        if (!passwordPattern.test(password.value)) {
            passwordError.textContent = "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.";
            return false;
        }
        password.textContent = "";
        return true;
    }

    function validateForm() {
        return validateUsername() && validateEmail() && validatePassword();
    }

    function clearError(input, errorElement) {
        errorElement.textContent = "";
        input.classList.remove("invalid");
    }
});
