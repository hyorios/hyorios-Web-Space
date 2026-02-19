document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('register-form');
    const loginForm = document.getElementById('login-form');
    const messageDiv = document.getElementById('message');

    const showMessage = (msg, isError = false) => {
        if (messageDiv) {
            messageDiv.textContent = msg;
            messageDiv.style.color = isError ? 'red' : 'green';
        }
    };

    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('/users/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email, password }),
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.detail || `HTTP error! status: ${response.status}`);
                }

                showMessage(`User ${data.email} registered successfully! You can now log in.`);
                registerForm.reset();

            } catch (error) {
                showMessage(error.message, true);
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const formData = new URLSearchParams();
            formData.append('username', email);
            formData.append('password', password);

            try {
                const response = await fetch('/token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: formData,
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.detail || `HTTP error! status: ${response.status}`);
                }

                localStorage.setItem('accessToken', data.access_token);
                showMessage('Login successful! Redirecting...');
                window.location.href = '/';

            } catch (error) {
                showMessage(error.message, true);
            }
        });
    }
});
