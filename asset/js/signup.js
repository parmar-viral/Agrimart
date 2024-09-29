// document.addEventListener("DOMContentLoaded", function() {
//     const form = document.getElementById("signupForm");

//     const name = document.getElementById("name");
//     const surname = document.getElementById("surname");
//     const username = document.getElementById("username");
//     const email = document.getElementById("email");
//     const password = document.getElementById("password");
//     const confirmPassword = document.getElementById("confirmpassword");
//     const mobile = document.getElementById("mobile");

//     const nameError = document.getElementById("nameError");
//     const surnameError = document.getElementById("surnamenameError");
//     const usernameError = document.getElementById("usernameError");
//     const emailError = document.getElementById("emailError");
//     const passwordError = document.getElementById("passwordError");
//     const confirmPasswordError = document.getElementById("confirmPasswordError");
//     const mobileError = document.getElementById("mobileError");

//     let touchedFields = {};

//     function validateField(field, validationFunction, errorElement) {
//         if (!validationFunction()) {
//             field.classList.add("invalid");
//             errorElement.style.display = "block";
//             return false;
//         } else {
//             field.classList.remove("invalid");
//             errorElement.style.display = "none";
//             return true;
//         }
//     }

//     function addValidationListeners(field, validationFunction, errorElement) {
//         field.addEventListener("blur", function(event) {
//             if (touchedFields[field.id]) {
//                 validateField(field, validationFunction, errorElement);
//             }
//         });

//         field.addEventListener("focus", function(event) {
//             touchedFields[field.id] = true;
//             clearError(field, errorElement);
//         });

//         field.addEventListener("input", function(event) {
//             if (touchedFields[field.id]) {
//                 validateField(field, validationFunction, errorElement);
//             }
//         });
//     }

//     addValidationListeners(username, validateUsername, usernameError);
//     addValidationListeners(email, validateEmail, emailError);
//     addValidationListeners(password, validatePassword, passwordError);
//     addValidationListeners(confirmPassword, validateConfirmPassword, confirmPasswordError);
//     addValidationListeners(mobile, validateMobile, mobileError);

//     form.addEventListener("submit", function(event) {
//         if (!validateForm()) {
//             event.preventDefault();
//         }
//     });

//     function validateUsername() {
//         const usernamePattern = /^[a-zA-Z0-9]{3,15}$/;
//         if (!usernamePattern.test(username.value)) {
//             usernameError.textContent = "Username must be 3-15 characters long and contain only alphanumeric characters.";
//             return false;
//         } else {
//             usernameError.textContent = "";
//             return true;
//         }
//     }

//     function validateEmail() {
//         const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
//         if (!emailPattern.test(email.value)) {
//             emailError.textContent = "Please enter a valid email address.";
//             return false;
//         } else {
//             emailError.textContent = "";
//             return true;
//         }
//     }

//     function validatePassword() {
//         if (password.value.length < 6) {
//             passwordError.textContent = "Password must be at least 6 characters long.";
//             return false;
//         } else {
//             passwordError.textContent = "";
//             return true;
//         }
//     }

//     function validateConfirmPassword() {
//         if (password.value !== confirmPassword.value) {
//             confirmPasswordError.textContent = "Passwords do not match.";
//             return false;
//         } else {
//             confirmPasswordError.textContent = "";
//             return true;
//         }
//     }

//     function validateMobile() {
//         const mobilePattern = /^\d{10}$/;
//         if (!mobilePattern.test(mobile.value)) {
//             mobileError.textContent = "Please enter a valid 10-digit mobile number.";
//             return false;
//         } else {
//             mobileError.textContent = "";
//             return true;
//         }
//     }

//     function validateForm() {
//         return validateUsername() && validateEmail() && validatePassword() && validateConfirmPassword() && validateMobile();
//     }

//     function clearError(input, errorElement) {
//         errorElement.textContent = "";
//         input.classList.remove("invalid");
//     }
// });

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("signupForm");

    const name = document.getElementById("name");
    const surname = document.getElementById("surname");
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
    const confirmPasswordError = document.getElementById("confirmPasswordError");
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
        field.addEventListener("blur", function() {
            if (touchedFields[field.id]) {
                validateField(field, validationFunction, errorElement);
            }
        });

        field.addEventListener("focus", function() {
            touchedFields[field.id] = true;
            clearError(field, errorElement);
        });

        field.addEventListener("input", function() {
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

    form.addEventListener("submit", async function(event) {
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
        if (password.value.length < 6) {
            passwordError.textContent = "Password must be at least 6 characters long.";
            return false;
        } else {
            passwordError.textContent = "";
            return true;
        }
    }

    function validateConfirmPassword() {
        if (password.value !== confirmPassword.value) {
            confirmPasswordError.textContent = "Passwords do not match.";
            return false;
        } else {
            confirmPasswordError.textContent = "";
            return true;
        }
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
