document.addEventListener("DOMContentLoaded", () => {
    // 1. ENGINE DE TRADUÇÃO (i18n)
    const translations = {
        pt: {
            nav_apps: "Aplicações", nav_system: "Sistema", menu_overview: "Visão Geral", menu_directory: "Diretório", menu_add: "Adicionar", menu_settings: "Configurações",
            overview_title: "Visão Geral do Núcleo", overview_sub: "Monitoramento em tempo real.", sys_online: "SISTEMA ONLINE",
            stat_volume: "VOLUME DE DADOS", stat_stable: "↑ Crescimento Estável", stat_integrity: "INTEGRIDADE (DB)", stat_no_corruption: "Zero corrupções", stat_latency: "LATÊNCIA MÉDIA", stat_optimized: "Otimização máxima",
            activity_map: "Mapa de Atividade", dir_title: "Diretório Central", dir_sub: "Gerenciamento de credenciais.", search_placeholder: "Pesquisar...",
            th_name: "NOME", th_email: "E-MAIL", th_course: "CURSO", th_cmd: "AÇÕES", btn_edit: "Editar", btn_del: "Apagar",
            add_title: "Novo Protocolo", label_name: "Nome", label_course: "Curso", btn_save: "Salvar",
            settings_title: "Configurações", settings_subtitle: "Gerencie temas e idiomas.", visual_prefs: "Preferências Visuais",
            theme_select: "Tema", opt_dark: "Escuro OLED", opt_light: "Claro Minimal", lang_select: "Idioma", layout_select: "Arquitetura do Sistema",
            diag_title: "Status de Segurança", diag_protected: "PROTEGIDO", diag_xss: "Prevenção XSS", diag_sql: "SQL Injection", diag_active: "Ativa",
            modal_confirm: "Confirmar Exclusão", modal_text: "Esta ação é permanente.", btn_cancel: "Cancelar", btn_del_confirm: "Excluir"
        },
        en: {
            nav_apps: "Applications", nav_system: "System", menu_overview: "Overview", menu_directory: "Directory", menu_add: "Add Entry", menu_settings: "Settings",
            overview_title: "Core Overview", overview_sub: "Real-time monitoring.", sys_online: "SYSTEM ONLINE",
            stat_volume: "DATA VOLUME", stat_stable: "↑ Stable Growth", stat_integrity: "INTEGRITY (DB)", stat_no_corruption: "No corruption", stat_latency: "AVG LATENCY", stat_optimized: "Peak optimization",
            activity_map: "Activity Map", dir_title: "Central Directory", dir_sub: "Credential management.", search_placeholder: "Search...",
            th_name: "NAME", th_email: "E-MAIL", th_course: "COURSE", th_cmd: "ACTIONS", btn_edit: "Edit", btn_del: "Purge",
            add_title: "New Protocol", label_name: "Full Name", label_course: "Course", btn_save: "Save Data",
            settings_title: "System Settings", settings_subtitle: "Manage theme and language.", visual_prefs: "Visual Preferences",
            theme_select: "System Theme", opt_dark: "Dark OLED", opt_light: "Light Minimal", lang_select: "Language", layout_select: "System Architecture",
            diag_title: "Security Status", diag_protected: "PROTECTED", diag_xss: "XSS Prevention", diag_sql: "SQL Injection", diag_active: "Active",
            modal_confirm: "Confirm Delete", modal_text: "This action cannot be undone.", btn_cancel: "Abort", btn_del_confirm: "Delete"
        },
        es: {
            nav_apps: "Aplicaciones", nav_system: "Sistema", menu_overview: "Resumen", menu_directory: "Directorio", menu_add: "Añadir", menu_settings: "Configuraciones",
            overview_title: "Resumen del Núcleo", overview_sub: "Monitoreo en tiempo real.", sys_online: "SISTEMA ONLINE",
            stat_volume: "VOLUMEN DE DATOS", stat_stable: "↑ Crecimiento Estable", stat_integrity: "INTEGRIDAD (DB)", stat_no_corruption: "Cero corrupciones", stat_latency: "LATENCIA MEDIA", stat_optimized: "Optimización máxima",
            activity_map: "Mapa de Actividad", dir_title: "Directorio Central", dir_sub: "Gestión de credenciales.", search_placeholder: "Buscar...",
            th_name: "NOMBRE", th_email: "E-MAIL", th_course: "CURSO", th_cmd: "ACCIONES", btn_edit: "Editar", btn_del: "Borrar",
            add_title: "Nuevo Protocolo", label_name: "Nombre", label_course: "Curso", btn_save: "Guardar",
            settings_title: "Configuraciones", settings_subtitle: "Gestione temas e idiomas.", visual_prefs: "Preferencias",
            theme_select: "Tema", opt_dark: "Oscuro OLED", opt_light: "Luz Minimal", lang_select: "Idioma", layout_select: "Arquitectura del Sistema",
            diag_title: "Estado de Seguridad", diag_protected: "PROTEGIDO", diag_xss: "Prevención XSS", diag_sql: "SQL Injection", diag_active: "Activa",
            modal_confirm: "Confirmar Borrado", modal_text: "Esta acción es permanente.", btn_cancel: "Cancelar", btn_del_confirm: "Borrar"
        }
    };

    let currentLang = localStorage.getItem('omni-lang') || 'pt';

    function updateLanguage(lang) {
        currentLang = lang;
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang][key]) el.textContent = translations[lang][key];
        });
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (translations[lang][key]) el.placeholder = translations[lang][key];
        });
        localStorage.setItem('omni-lang', lang);
    }

    // 2. TEMA
    function updateTheme(theme) {
        document.body.classList.toggle('light-mode', theme === 'light');
        localStorage.setItem('omni-theme', theme);
    }

    const langSelector = document.getElementById('lang-selector');
    const themeSelector = document.getElementById('theme-selector');
    const layoutSelector = document.getElementById('layout-selector');

    if(langSelector) langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    if(themeSelector) themeSelector.addEventListener('change', e => updateTheme(e.target.value));
    
    // O GRANDE TRUQUE DO ROTEAMENTO
    if(layoutSelector) {
        // Pega o valor do cookie 'system_layout'
        const currentLayout = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'omni';
        layoutSelector.value = currentLayout;
        
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload(); // Recarrega para o index.php puxar o novo arquivo!
        });
    }

    // Carregar configurações iniciais
    const savedTheme = localStorage.getItem('omni-theme') || 'dark';
    if(langSelector) langSelector.value = currentLang; 
    if(themeSelector) themeSelector.value = savedTheme;
    updateLanguage(currentLang); updateTheme(savedTheme);

    // 3. SPOTLIGHT
    document.addEventListener('mousemove', e => {
        document.querySelectorAll('.bionic-card').forEach(card => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
            card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
        });
    });

    // 4. SPA NAVIGATION
    const navItems = document.querySelectorAll('.nav-item[data-view]');
    const views = document.querySelectorAll('.view-section');
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            const target = item.getAttribute('data-view');
            navItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            views.forEach(v => {
                v.classList.remove('active');
                if(v.id === target) v.classList.add('active');
            });
        });
    });

    // 5. SEARCH & MODAL
    const searchInput = document.getElementById('tableSearch');
    if(searchInput) {
        searchInput.addEventListener('keyup', e => {
            const val = e.target.value.toLowerCase();
            document.querySelectorAll('.table-row').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
            });
        });
    }

    const modal = document.getElementById('deleteModal');
    let delUrl = '';
    document.querySelectorAll('.custom-delete-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault(); delUrl = btn.href; modal.classList.add('active');
        });
    });
    const btnCancel = document.getElementById('btnCancelDelete');
    if(btnCancel) btnCancel.onclick = () => modal.classList.remove('active');
    
    const btnConfirm = document.getElementById('btnConfirmDelete');
    if(btnConfirm) btnConfirm.onclick = () => window.location.href = delUrl;
});

window.showToast = (msg) => {
    const t = document.getElementById('toast');
    if(t) {
        document.getElementById('toast-msg').textContent = msg;
        t.classList.add('show'); setTimeout(() => t.classList.remove('show'), 3000);
    }
};