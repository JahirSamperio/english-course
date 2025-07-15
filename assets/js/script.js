document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const inputs = document.querySelectorAll('input, select');
    
    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.style.borderColor = '#48bb78';
            } else {
                this.style.borderColor = '#e2e8f0';
            }
        });
    });
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (input.hasAttribute('required') && input.value.trim() === '') {
                input.style.borderColor = '#f56565';
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('🚨 Por favor completa todos los campos');
        }
    });
    
    // Efectos visuales
    const loginBtn = document.querySelector('.login-btn');
    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            this.innerHTML = '⏳ Entrando...';
        });
    }
});

// Función para cerrar sesión
function logout() {
    if (confirm('¿Estás seguro de que quieres salir?')) {
        window.location.href = 'logout.php';
    }
}