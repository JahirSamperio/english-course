// Sistema de cambio de fondo basado en progreso
class ProgressBackground {
    constructor() {
        this.currentLevel = 0;
        this.maxLevel = 3;
        this.init();
    }

    init() {
        // Detectar completación de actividades
        this.setupActivityListeners();
        
        // Restaurar estado desde localStorage
        this.restoreProgress();
    }

    setupActivityListeners() {
        // Escuchar eventos de completación de ejercicios
        document.addEventListener('exerciseCompleted', () => {
            this.advanceProgress();
        });

        // Escuchar clicks en botones de envío
        document.addEventListener('click', (e) => {
            if (e.target.matches('.btn-submit, .big-btn.start, .nav-btn.exercises')) {
                setTimeout(() => this.advanceProgress(), 500);
            }
        });

        // Escuchar cambios en barras de progreso
        const progressBars = document.querySelectorAll('.progress-fill');
        progressBars.forEach(bar => {
            const observer = new MutationObserver(() => {
                const width = parseInt(bar.style.width) || 0;
                if (width > 75) {
                    this.advanceProgress();
                }
            });
            observer.observe(bar, { attributes: true, attributeFilter: ['style'] });
        });
    }

    advanceProgress() {
        if (this.currentLevel < this.maxLevel) {
            this.currentLevel++;
            this.updateBackground();
            this.saveProgress();
        }
    }

    updateBackground() {
        const body = document.body;
        
        // Remover clases anteriores
        body.classList.remove('progress-1', 'progress-2', 'progress-3', 'completed');
        
        // Aplicar nueva clase con transición suave
        setTimeout(() => {
            if (this.currentLevel === this.maxLevel) {
                body.classList.add('completed');
                this.showCompletionFeedback();
            } else {
                body.classList.add(`progress-${this.currentLevel}`);
            }
        }, 100);
    }

    showCompletionFeedback() {
        // Feedback visual sutil al completar
        const feedback = document.createElement('div');
        feedback.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, #4caf50, #8bc34a);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.5s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        `;
        feedback.textContent = '¡Excelente progreso! 🌟';
        
        document.body.appendChild(feedback);
        
        // Mostrar con animación
        setTimeout(() => {
            feedback.style.opacity = '1';
            feedback.style.transform = 'translateY(0)';
        }, 100);
        
        // Ocultar después de 3 segundos
        setTimeout(() => {
            feedback.style.opacity = '0';
            feedback.style.transform = 'translateY(-20px)';
            setTimeout(() => feedback.remove(), 500);
        }, 3000);
    }

    saveProgress() {
        localStorage.setItem('progressLevel', this.currentLevel.toString());
    }

    restoreProgress() {
        const saved = localStorage.getItem('progressLevel');
        if (saved) {
            this.currentLevel = parseInt(saved);
            this.updateBackground();
        }
    }

    reset() {
        this.currentLevel = 0;
        localStorage.removeItem('progressLevel');
        document.body.classList.remove('progress-1', 'progress-2', 'progress-3', 'completed');
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.progressBg = new ProgressBackground();
});

// Función global para avanzar progreso manualmente
function advanceProgress() {
    if (window.progressBg) {
        window.progressBg.advanceProgress();
    }
}

// Función global para resetear progreso
function resetProgress() {
    if (window.progressBg) {
        window.progressBg.reset();
    }
}