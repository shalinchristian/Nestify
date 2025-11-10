document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const signupLink = document.getElementById('signup-link');
    const loginLink = document.getElementById('login-link');

    // Handle manual clicking (Sliding effect)
    signupLink.addEventListener('click', (e) => {
        e.preventDefault();
        container.classList.add('active');
    });

    loginLink.addEventListener('click', (e) => {
        e.preventDefault();
        container.classList.remove('active');
    });
});