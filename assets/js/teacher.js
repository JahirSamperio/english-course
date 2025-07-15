function logout() {
    if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
        window.location.href = '/englishdemo/?controller=auth&action=logout';
    }
}