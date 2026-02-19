document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('register-form');
    const loginForm = document.getElementById('login-form');
    const messageElement = document.getElementById('message');

    if (registerForm) {
        registerForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const email = event.target.email.value;
            const password = event.target.password.value;

            try {
                const response = await fetch('/users/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email, password }),
                });

                const data = await response.json();

                if (response.ok) {
                    messageElement.textContent = 'Registrierung erfolgreich! Sie können sich jetzt einloggen.';
                    messageElement.style.color = 'green';
                    setTimeout(() => window.location.href = '/login', 2000);
                } else {
                    messageElement.textContent = `Fehler: ${data.detail}`;
                    messageElement.style.color = 'red';
                }
            } catch (error) {
                messageElement.textContent = 'Ein Netzwerkfehler ist aufgetreten.';
                messageElement.style.color = 'red';
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const email = event.target.email.value;
            const password = event.target.password.value;

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

                if (response.ok) {
                    localStorage.setItem('accessToken', data.access_token);
                    messageElement.textContent = 'Login erfolgreich! Sie werden weitergeleitet...';
                    messageElement.style.color = 'green';
                    // Später hier auf ein echtes Dashboard weiterleiten
                    // window.location.href = '/dashboard'; 
                } else {
                    messageElement.textContent = `Fehler: ${data.detail}`;
                    messageElement.style.color = 'red';
                }
            } catch (error) {
                messageElement.textContent = 'Ein Netzwerkfehler ist aufgetreten.';
                messageElement.style.color = 'red';
            }
        });
    }
});
