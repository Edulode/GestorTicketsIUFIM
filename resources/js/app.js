import '../css/app.css';
import './bootstrap';

// Funcionalidad básica para la aplicación
document.addEventListener('DOMContentLoaded', function() {
    console.log('Gestor de Tickets IUFIM - Aplicación cargada correctamente');
    
    // Inicializar componentes básicos
    initializeComponents();
});

function initializeComponents() {
    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-yellow-50');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
    
    // Confirmar eliminaciones
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm-delete') || '¿Estás seguro de que deseas eliminar este elemento?';
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // Formularios con confirmación
    const forms = document.querySelectorAll('[data-confirm-submit]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm-submit') || '¿Estás seguro de que deseas realizar esta acción?';
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
}
