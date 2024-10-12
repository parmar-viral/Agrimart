document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signupForm");

    const name = document.getElementById("fname");
    const surname = document.getElementById("lname");
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmpassword");
    const mobile = document.getElementById("mobile");

    const nameError = document.getElementById("nameError");
    const surnameError = document.getElementById("surnameError");
    const usernameError = document.getElementById("usernameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmpasswordError");
    const mobileError = document.getElementById("mobileError");

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
        field.addEventListener("blur", function () {
            if (touchedFields[field.id]) {
                validateField(field, validationFunction, errorElement);
            }
        });

        field.addEventListener("focus", function () {
            touchedFields[field.id] = true;
            clearError(field, errorElement);
        });

        field.addEventListener("input", function () {
            if (touchedFields[field.id]) {
                validateField(field, validationFunction, errorElement);
            }
        });
    }

    addValidationListeners(username, validateUsername, usernameError);
    addValidationListeners(email, validateEmail, emailError);
    addValidationListeners(password, validatePassword, passwordError);
    addValidationListeners(confirmPassword, validateConfirmPassword, confirmPasswordError);
    addValidationListeners(mobile, validateMobile, mobileError);

    form.addEventListener("submit", async function (event) {
        if (!validateForm() || !(await validateUniqueEntries())) {
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

    function validateConfirmPassword() {
        // First, validate the password itself
        if (!validatePassword()) {
            return false; // If the password isn't valid, don't bother checking for matching
        }

        // Check if the password and confirm password match
        if (password.value !== confirmPassword.value) {
            confirmPasswordError.textContent = "Passwords do not match.";
            return false;
        }

        // If both passwords match, clear the error message
        confirmPasswordError.textContent = "";
        return true;
    }

    function validateMobile() {
        const mobilePattern = /^\d{10}$/;
        if (!mobilePattern.test(mobile.value)) {
            mobileError.textContent = "Please enter a valid 10-digit mobile number.";
            return false;
        } else {
            mobileError.textContent = "";
            return true;
        }
    }

    async function validateUniqueEntries() {
        // Example API calls to check for duplicate entries
        try {
            const [usernameResponse, emailResponse, mobileResponse] = await Promise.all([
                fetch(`/check-username.php?username=${encodeURIComponent(username.value)}`),
                fetch(`/check-email.php?email=${encodeURIComponent(email.value)}`),
                fetch(`/check-mobile.php?mobile=${encodeURIComponent(mobile.value)}`)
            ]);

            const [usernameData, emailData, mobileData] = await Promise.all([
                usernameResponse.json(),
                emailResponse.json(),
                mobileResponse.json()
            ]);

            let isValid = true;

            if (usernameData.exists) {
                usernameError.textContent = "Username is already taken.";
                isValid = false;
            }
            addValidationListeners(confirmPassword, validateConfirmPassword, confirmPasswordError);
            if (emailData.exists) {
                emailError.textContent = "Email is already registered.";
                isValid = false;
            }

            if (mobileData.exists) {
                mobileError.textContent = "Mobile number is already registered.";
                isValid = false;
            }

            return isValid;
        } catch (error) {
            console.error('Error checking for unique entries:', error);
            return false;
        }
    }

    function clearError(input, errorElement) {
        errorElement.textContent = "";
        input.classList.remove("invalid");
    }
});
