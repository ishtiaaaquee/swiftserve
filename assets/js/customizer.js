/**
 * Theme Customizer
 * Allows users to customize colors and fonts
 */

class ThemeCustomizer {
    constructor() {
        this.isOpen = false;
        this.init();
    }

    init() {
        this.createCustomizerUI();
        this.attachEventListeners();
        this.loadSavedSettings();
    }

    createCustomizerUI() {
        const customizerHTML = `
            <div class="theme-customizer" id="themeCustomizer">
                <button class="customizer-toggle" id="customizerToggle">
                    <i class="fas fa-palette"></i>
                </button>
                
                <div class="customizer-panel" id="customizerPanel">
                    <div class="customizer-header">
                        <h4><i class="fas fa-palette me-2"></i>Customize</h4>
                        <button class="btn-close-customizer" id="closeCustomizer">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="customizer-content">
                        <div class="customizer-section">
                            <h5>Try Other Colors</h5>
                            <div class="color-grid">
                                <button class="color-option" data-primary="#ff6b35" data-secondary="#f7931e" title="Orange (Default)">
                                    <span style="background: #ff6b35"></span>
                                    <span style="background: #f7931e"></span>
                                </button>
                                <button class="color-option" data-primary="#3b82f6" data-secondary="#2563eb" title="Blue">
                                    <span style="background: #3b82f6"></span>
                                    <span style="background: #2563eb"></span>
                                </button>
                                <button class="color-option" data-primary="#10b981" data-secondary="#059669" title="Green">
                                    <span style="background: #10b981"></span>
                                    <span style="background: #059669"></span>
                                </button>
                                <button class="color-option" data-primary="#ef4444" data-secondary="#dc2626" title="Red">
                                    <span style="background: #ef4444"></span>
                                    <span style="background: #dc2626"></span>
                                </button>
                                <button class="color-option" data-primary="#f59e0b" data-secondary="#d97706" title="Amber">
                                    <span style="background: #f59e0b"></span>
                                    <span style="background: #d97706"></span>
                                </button>
                                <button class="color-option" data-primary="#8b5cf6" data-secondary="#7c3aed" title="Purple">
                                    <span style="background: #8b5cf6"></span>
                                    <span style="background: #7c3aed"></span>
                                </button>
                                <button class="color-option" data-primary="#ec4899" data-secondary="#db2777" title="Pink">
                                    <span style="background: #ec4899"></span>
                                    <span style="background: #db2777"></span>
                                </button>
                                <button class="color-option" data-primary="#14b8a6" data-secondary="#0d9488" title="Teal">
                                    <span style="background: #14b8a6"></span>
                                    <span style="background: #0d9488"></span>
                                </button>
                                <button class="color-option" data-primary="#f97316" data-secondary="#ea580c" title="Orange Alt">
                                    <span style="background: #f97316"></span>
                                    <span style="background: #ea580c"></span>
                                </button>
                                <button class="color-option" data-primary="#06b6d4" data-secondary="#0891b2" title="Cyan">
                                    <span style="background: #06b6d4"></span>
                                    <span style="background: #0891b2"></span>
                                </button>
                            </div>
                        </div>

                        <div class="customizer-section">
                            <h5>Try Other Fonts</h5>
                            <div class="font-grid">
                                <button class="font-option active" data-font="Poppins" data-bg="#fef9f3" style="font-family: 'Poppins', sans-serif">Aa</button>
                                <button class="font-option" data-font="Inter" data-bg="#f0f4f8" style="font-family: 'Inter', sans-serif">Aa</button>
                                <button class="font-option" data-font="Roboto" data-bg="#fafafa" style="font-family: 'Roboto', sans-serif">Aa</button>
                                <button class="font-option" data-font="Montserrat" data-bg="#fff8f0" style="font-family: 'Montserrat', sans-serif">Aa</button>
                                <button class="font-option" data-font="Open Sans" data-bg="#f5f8fa" style="font-family: 'Open Sans', sans-serif">Aa</button>
                                <button class="font-option" data-font="Lato" data-bg="#fef7f3" style="font-family: 'Lato', sans-serif">Aa</button>
                                <button class="font-option" data-font="Nunito" data-bg="#fff9f5" style="font-family: 'Nunito', sans-serif">Aa</button>
                                <button class="font-option" data-font="Raleway" data-bg="#f8f9fb" style="font-family: 'Raleway', sans-serif">Aa</button>
                                <button class="font-option" data-font="Playfair Display" data-bg="#fdf8f3" style="font-family: 'Playfair Display', serif">Aa</button>
                                <button class="font-option" data-font="Quicksand" data-bg="#fff4f0" style="font-family: 'Quicksand', sans-serif">Aa</button>
                                <button class="font-option" data-font="Ubuntu" data-bg="#f4f6f8" style="font-family: 'Ubuntu', sans-serif">Aa</button>
                                <button class="font-option" data-font="Work Sans" data-bg="#fef5f0" style="font-family: 'Work Sans', sans-serif">Aa</button>
                            </div>
                        </div>

                        <div class="customizer-section">
                            <button class="btn btn-outline-primary w-100 mb-2" id="resetCustomizer">
                                <i class="fas fa-undo me-2"></i>Reset to Default
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', customizerHTML);
        this.loadGoogleFonts();
    }

    loadGoogleFonts() {
        const fonts = [
            'Inter:wght@300;400;500;600;700',
            'Roboto:wght@300;400;500;600;700',
            'Montserrat:wght@300;400;500;600;700',
            'Open+Sans:wght@300;400;500;600;700',
            'Lato:wght@300;400;500;600;700',
            'Nunito:wght@300;400;500;600;700',
            'Raleway:wght@300;400;500;600;700',
            'Poppins:wght@300;400;500;600;700',
            'Playfair+Display:wght@400;500;600;700',
            'Quicksand:wght@300;400;500;600;700',
            'Ubuntu:wght@300;400;500;600;700',
            'Work+Sans:wght@300;400;500;600;700'
        ];
        const link = document.createElement('link');
        link.href = `https://fonts.googleapis.com/css2?${fonts.map(f => `family=${f}&`).join('')}display=swap`;
        link.rel = 'stylesheet';
        document.head.appendChild(link);
    }

    attachEventListeners() {
        const toggle = document.getElementById('customizerToggle');
        const close = document.getElementById('closeCustomizer');
        const panel = document.getElementById('customizerPanel');
        const reset = document.getElementById('resetCustomizer');

        toggle.addEventListener('click', () => this.togglePanel());
        close.addEventListener('click', () => this.closePanel());

        // Color options
        document.querySelectorAll('.color-option').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const primary = btn.dataset.primary;
                const secondary = btn.dataset.secondary;
                this.applyColors(primary, secondary);
                this.setActiveColor(btn);
            });
        });

        // Font options
        document.querySelectorAll('.font-option').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const font = btn.dataset.font;
                const bgColor = btn.dataset.bg;
                this.applyFont(font, bgColor);
                this.setActiveFont(btn);
            });
        });

        // Reset
        reset.addEventListener('click', () => this.resetToDefault());
    }

    togglePanel() {
        this.isOpen = !this.isOpen;
        const panel = document.getElementById('customizerPanel');
        panel.classList.toggle('active', this.isOpen);
    }

    closePanel() {
        this.isOpen = false;
        document.getElementById('customizerPanel').classList.remove('active');
    }

    applyColors(primary, secondary) {
        const root = document.documentElement;
        root.style.setProperty('--primary-color', primary);
        root.style.setProperty('--primary', primary);
        root.style.setProperty('--secondary-color', secondary);
        root.style.setProperty('--secondary', secondary);
        root.style.setProperty('--gradient-primary', `linear-gradient(135deg, ${primary} 0%, ${secondary} 100%)`);
        
        // Save to localStorage
        localStorage.setItem('theme-primary', primary);
        localStorage.setItem('theme-secondary', secondary);
    }

    applyFont(font, bgColor) {
        document.body.style.fontFamily = `'${font}', sans-serif`;
        
        // Apply background colors
        const root = document.documentElement;
        if (bgColor) {
            root.style.setProperty('--bg-secondary', bgColor);
            root.style.setProperty('--bg-tertiary', this.adjustBrightness(bgColor, -5));
            
            // For dark mode, adjust accordingly
            const isDark = document.body.classList.contains('dark-mode');
            if (isDark) {
                root.style.setProperty('--bg-secondary', this.getDarkModeColor(bgColor));
            }
        }
        
        localStorage.setItem('theme-font', font);
        localStorage.setItem('theme-bg', bgColor);
    }
    
    adjustBrightness(hex, percent) {
        // Convert hex to RGB
        const num = parseInt(hex.replace('#', ''), 16);
        const r = Math.max(0, Math.min(255, (num >> 16) + percent));
        const g = Math.max(0, Math.min(255, ((num >> 8) & 0x00FF) + percent));
        const b = Math.max(0, Math.min(255, (num & 0x0000FF) + percent));
        return `#${((r << 16) | (g << 8) | b).toString(16).padStart(6, '0')}`;
    }
    
    getDarkModeColor(lightColor) {
        // Convert light background to dark mode equivalent
        const colorMap = {
            '#fef9f3': '#22273b',
            '#f0f4f8': '#1e2537',
            '#fafafa': '#21262d',
            '#fff8f0': '#252a3a',
            '#f5f8fa': '#1f2536',
            '#fef7f3': '#23283c',
            '#fff9f5': '#24293d',
            '#f8f9fb': '#1d2435',
            '#fdf8f3': '#22273a',
            '#fff4f0': '#252939',
            '#f4f6f8': '#1e2436',
            '#fef5f0': '#23283b'
        };
        return colorMap[lightColor] || '#22273b';
    }

    setActiveColor(activeBtn) {
        document.querySelectorAll('.color-option').forEach(btn => {
            btn.classList.remove('active');
        });
        activeBtn.classList.add('active');
    }

    setActiveFont(activeBtn) {
        document.querySelectorAll('.font-option').forEach(btn => {
            btn.classList.remove('active');
        });
        activeBtn.classList.add('active');
    }

    loadSavedSettings() {
        const savedPrimary = localStorage.getItem('theme-primary');
        const savedSecondary = localStorage.getItem('theme-secondary');
        const savedFont = localStorage.getItem('theme-font');
        const savedBg = localStorage.getItem('theme-bg');

        if (savedPrimary && savedSecondary) {
            this.applyColors(savedPrimary, savedSecondary);
            // Set active color button
            document.querySelectorAll('.color-option').forEach(btn => {
                if (btn.dataset.primary === savedPrimary) {
                    btn.classList.add('active');
                }
            });
        }

        if (savedFont) {
            this.applyFont(savedFont, savedBg);
            // Set active font button
            document.querySelectorAll('.font-option').forEach(btn => {
                if (btn.dataset.font === savedFont) {
                    btn.classList.add('active');
                }
            });
        }
    }

    resetToDefault() {
        this.applyColors('#ff6b35', '#f7931e');
        this.applyFont('Poppins', '#fef9f3');
        localStorage.removeItem('theme-primary');
        localStorage.removeItem('theme-secondary');
        localStorage.removeItem('theme-font');
        localStorage.removeItem('theme-bg');
        
        // Reset active states
        document.querySelectorAll('.color-option')[0].classList.add('active');
        document.querySelectorAll('.font-option')[0].classList.add('active');
        
        // Show notification
        this.showNotification('Theme reset to default');
    }

    showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'customizer-notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
}

// Initialize customizer when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ThemeCustomizer();
});
