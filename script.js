document.addEventListener("DOMContentLoaded", () => {
    
    // --- 1. DICIONÁRIO DE TRADUÇÃO (PT, EN, ES) ---
    const translations = {
        pt: {
            nav_apps: "Aplicações", nav_system: "Sistema", menu_overview: "Visão Geral", menu_directory: "Diretório", menu_add: "Adicionar", menu_settings: "Diagnóstico",
            overview_title: "Visão Geral do Núcleo", overview_sub: "Monitoramento em tempo real.", sys_online: "SISTEMA ONLINE",
            stat_volume: "VOLUME DE DADOS", stat_stable: "↑ Crescimento Estável", stat_integrity: "INTEGRIDADE (DB)", stat_no_corruption: "Zero corrupções detectadas", stat_latency: "LATÊNCIA MÉDIA", stat_optimized: "Otimização máxima",
            heatmap_title: "Frequência de Registro (Últimos 90 Dias)", heat_less: "Menos", heat_more: "Mais",
            dir_title: "Diretório Central", dir_sub: "Gerenciamento de operadores e credenciais.", btn_new: "+ Novo Registro", search_placeholder: "Pesquisar operador ou e-mail...",
            th_name: "OPERADOR", th_email: "CONTATO", th_course: "VÍNCULO", th_actions: "AÇÕES", btn_edit: "Editar", btn_del: "Apagar",
            add_title: "Novo Protocolo", label_name: "Nome Completo", label_email: "E-mail de Contato", label_course: "Chave do Curso", btn_save: "Finalizar Cadastro",
            settings_title: "Diagnóstico do Servidor", settings_subtitle: "Gerenciamento de ambiente, tradução e temas.", pref_visual: "Preferências", label_theme: "Tema do Sistema", opt_dark: "Dark OLED (Padrão)", opt_light: "Light Minimalist", label_lang: "Idioma da Interface",
            diag_db_title: "Conexão com Banco", diag_driver: "Driver Utilizado", diag_sec_title: "Segurança da Aplicação", diag_protected: "PROTEGIDO", diag_xss: "Prevenção XSS", diag_sql: "SQL Injection", diag_active: "Ativa",
            modal_confirm: "Excluir Registro", modal_text: "Esta ação purgará os dados permanentemente.", btn_cancel: "Cancelar", btn_del_confirm: "Sim, Excluir",
            toast_processing: "Processando dados..."
        },
        en: {
            nav_apps: "Applications", nav_system: "System", menu_overview: "Overview", menu_directory: "Directory", menu_add: "Add Entry", menu_settings: "Diagnostics",
            overview_title: "Core Overview", overview_sub: "Real-time data monitoring.", sys_online: "SYSTEM ONLINE",
            stat_volume: "DATA VOLUME", stat_stable: "↑ Stable Growth", stat_integrity: "INTEGRITY (DB)", stat_no_corruption: "No corruption detected", stat_latency: "AVG LATENCY", stat_optimized: "Peak optimization",
            heatmap_title: "Registry Frequency (Last 90 Days)", heat_less: "Less", heat_more: "More",
            dir_title: "Central Directory", dir_sub: "Operator credential management.", btn_new: "+ New Registry", search_placeholder: "Search operator or email...",
            th_name: "OPERATOR", th_email: "CONTACT", th_course: "VECTOR", th_actions: "ACTIONS", btn_edit: "Edit", btn_del: "Purge",
            add_title: "New Protocol", label_name: "Full Name", label_email: "Contact Email", label_course: "Course Key", btn_save: "Complete Registry",
            settings_title: "Server Diagnostics", settings_subtitle: "Environment, translation and theme management.", pref_visual: "Preferences", label_theme: "System Theme", opt_dark: "Dark OLED (Default)", opt_light: "Light Minimalist", label_lang: "System Language",
            diag_db_title: "Database Connection", diag_driver: "Driver", diag_sec_title: "Application Security", diag_protected: "PROTECTED", diag_xss: "XSS Prevention", diag_sql: "SQL Injection", diag_active: "Active",
            modal_confirm: "Confirm Delete", modal_text: "This action will permanently delete data.", btn_cancel: "Abort", btn_del_confirm: "Yes, Delete",
            toast_processing: "Processing data..."
        },
        es: {
            nav_apps: "Aplicaciones", nav_system: "Sistema", menu_overview: "Resumen", menu_directory: "Directorio", menu_add: "Añadir", menu_settings: "Diagnóstico",
            overview_title: "Resumen del Núcleo", overview_sub: "Monitoreo en tiempo real.", sys_online: "SISTEMA ONLINE",
            stat_volume: "VOLUMEN DE DATOS", stat_stable: "↑ Crecimiento Estable", stat_integrity: "INTEGRIDAD (DB)", stat_no_corruption: "Cero corrupciones", stat_latency: "LATENCIA MEDIA", stat_optimized: "Optimización máxima",
            heatmap_title: "Frecuencia de Registro (Últimos 90 Días)", heat_less: "Menos", heat_more: "Más",
            dir_title: "Directorio Central", dir_sub: "Gestión de operadores y credenciales.", btn_new: "+ Nuevo Registro", search_placeholder: "Buscar operador...",
            th_name: "OPERADOR", th_email: "CONTACTO", th_course: "VÍNCULO", th_actions: "ACCIONES", btn_edit: "Editar", btn_del: "Borrar",
            add_title: "Nuevo Protocolo", label_name: "Nombre Completo", label_email: "Correo de Contacto", label_course: "Clave del Curso", btn_save: "Finalizar Registro",
            settings_title: "Diagnóstico del Servidor", settings_subtitle: "Gestión de entorno, traducción y temas.", pref_visual: "Preferencias", label_theme: "Tema del Sistema", opt_dark: "Dark OLED", opt_light: "Luz Minimalista", label_lang: "Idioma de Interfaz",
            diag_db_title: "Conexión con Base", diag_driver: "Driver", diag_sec_title: "Estado de Seguridad", diag_protected: "PROTEGIDO", diag_xss: "Prevención XSS", diag_sql: "SQL Injection", diag_active: "Activa",
            modal_confirm: "Borrar Permanente", modal_text: "El registro será borrado definitivamente.", btn_cancel: "Cancelar", btn_del_confirm: "Sí, Borrar",
            toast_processing: "Procesando datos..."
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

    // --- 2. ENGINE DE TEMAS ---
    function updateTheme(theme) {
        document.body.classList.toggle('light-mode', theme === 'light');
        localStorage.setItem('omni-theme', theme);
    }

    const langSelector = document.getElementById('lang-selector');
    const themeSelector = document.getElementById('theme-selector');

    langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    themeSelector.addEventListener('change', e => updateTheme(e.target.value));

    // Carregar preferências salvas
    const savedTheme = localStorage.getItem('omni-theme') || 'dark';
    langSelector.value = currentLang;
    themeSelector.value = savedTheme;
    updateLanguage(currentLang);
    updateTheme(savedTheme);

    // --- 3. EFEITO SPOTLIGHT ---
    document.addEventListener('mousemove', e => {
        document.querySelectorAll('.bionic-card').forEach(card => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
            card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
        });
    });

    // --- 4. SPA NAVIGATION ---
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

    // --- 5. SEARCH & MODAL ---
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
            e.preventDefault();
            delUrl = btn.href;
            modal.classList.add('active');
        });
    });
    document.getElementById('btnCancelDelete').onclick = () => modal.classList.remove('active');
    document.getElementById('btnConfirmDelete').onclick = () => window.location.href = delUrl;
});

window.showToast = (msg) => {
    const t = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
};