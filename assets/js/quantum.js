document.addEventListener("DOMContentLoaded", () => {
    
    // GERENCIADOR DE JANELAS ESPACIAIS (Quantum OS Logic)
    const dockIcons = document.querySelectorAll('.dock-icon');
    const windows = document.querySelectorAll('.spatial-window:not(.modal-window)');
    let maxZIndex = 10;

    function bringToFront(windowElement) {
        maxZIndex++;
        windowElement.style.zIndex = maxZIndex;
    }

    dockIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const targetId = icon.getAttribute('data-target');
            const targetWindow = document.getElementById(targetId);
            icon.classList.toggle('active');
            targetWindow.classList.toggle('active');
            if (targetWindow.classList.contains('active')) bringToFront(targetWindow);
        });
    });

    windows.forEach(win => {
        win.addEventListener('mousedown', () => bringToFront(win));
    });

    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const win = e.target.closest('.spatial-window');
            win.classList.remove('active');
            const dockIcon = document.querySelector(`.dock-icon[data-target="${win.id}"]`);
            if (dockIcon) dockIcon.classList.remove('active');
        });
    });

    // 2. LÓGICA DE TEMAS E IDIOMAS (COMO NOS OUTROS)
    const translations = {
        pt: {
            add_title: "TERMINAL DE ENTRADA v.4.0", label_name: "IDENTIFICAÇÃO DO OPERADOR", label_email: "CANAL DE COMUNICAÇÃO (E-MAIL)", label_course: "VETOR DE ACESSO (CURSO)", btn_save: "PROCESSAR DADOS",
            dir_title: "VISUALIZADOR DE MATRIZ", th_name: "Operador / Contato", th_course: "Vetor", th_cmd: "Controle",
            settings_title: "PREFERÊNCIAS DE SISTEMA", lang_select: "IDIOMA DO SISTEMA", theme_select: "ESQUEMA DE CORES", layout_select: "ARQUITETURA DO SISTEMA",
            modal_confirm: "Confirmar Purga de Dados?", modal_text: "Esta operação é irreversível.", btn_cancel: "CANCELAR", btn_confirm: "CONFIRMAR PURGA"
        },
        en: {
            add_title: "INPUT TERMINAL v.4.0", label_name: "OPERATOR IDENTIFICATION", label_email: "COMMS CHANNEL (E-MAIL)", label_course: "ACCESS VECTOR (COURSE)", btn_save: "PROCESS DATA",
            dir_title: "MATRIX VIEWER", th_name: "Operator / Contact", th_course: "Vector", th_cmd: "Control",
            settings_title: "SYSTEM PREFERENCES", lang_select: "SYSTEM LANGUAGE", theme_select: "COLOR SCHEME", layout_select: "SYSTEM ARCHITECTURE",
            modal_confirm: "Confirm Data Purge?", modal_text: "This operation is irreversible.", btn_cancel: "ABORT", btn_confirm: "CONFIRM PURGE"
        },
        es: {
            add_title: "TERMINAL DE ENTRADA v.4.0", label_name: "IDENTIFICACIÓN DEL OPERADOR", label_email: "CANAL DE COMUNICACIÓN (E-MAIL)", label_course: "VECTOR DE ACCESO (CURSO)", btn_save: "PROCESAR DATOS",
            dir_title: "VISOR DE MATRIZ", th_name: "Operador / Contacto", th_course: "Vector", th_cmd: "Control",
            settings_title: "PREFERENCIAS DEL SISTEMA", lang_select: "IDIOMA DEL SISTEMA", theme_select: "ESQUEMA DE COLORES", layout_select: "ARQUITECTURA DEL SISTEMA",
            modal_confirm: "¿Confirmar Purga de Datos?", modal_text: "Esta operación es irreversible.", btn_cancel: "CANCELAR", btn_confirm: "CONFIRMAR PURGA"
        }
    };

    let currentLang = localStorage.getItem('omni-lang') || 'pt';
    function updateLanguage(lang) {
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang][key]) el.textContent = translations[lang][key];
        });
        localStorage.setItem('omni-lang', lang);
    }

    function updateTheme(theme) {
        document.body.classList.toggle('light-theme', theme === 'light');
        localStorage.setItem('omni-theme', theme);
    }

    const langSelector = document.getElementById('lang-selector');
    const themeSelector = document.getElementById('theme-selector');
    const layoutSelector = document.getElementById('layout-selector');

    if(langSelector) langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    if(themeSelector) themeSelector.addEventListener('change', e => updateTheme(e.target.value));
    
    // O ROTEADOR QUE SALVA O COOKIE E RECARREGA O INDEX.PHP
    if(layoutSelector) {
        const currentLayout = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'omni';
        layoutSelector.value = currentLayout;
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload();
        });
    }

    const savedTheme = localStorage.getItem('omni-theme') || 'dark';
    if(langSelector) langSelector.value = currentLang;
    if(themeSelector) themeSelector.value = savedTheme;
    updateLanguage(currentLang); updateTheme(savedTheme);


    // LOGICA DO MODAL DE EXCLUSÃO
    const deleteTriggers = document.querySelectorAll('.custom-delete-trigger');
    const modalOverlay = document.getElementById('deleteModal');
    let deleteUrl = ''; 

    if (modalOverlay) {
        deleteTriggers.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); 
                deleteUrl = this.getAttribute('data-href'); 
                modalOverlay.classList.add('active'); 
            });
        });
        document.getElementById('btnCancelDelete').addEventListener('click', () => modalOverlay.classList.remove('active'));
        document.getElementById('btnConfirmDelete').addEventListener('click', () => window.location.href = deleteUrl);
    }
});