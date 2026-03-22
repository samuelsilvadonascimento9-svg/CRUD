document.addEventListener("DOMContentLoaded", () => {
    
    // 1. RELÓGIO DO SISTEMA TÁTICO
    const clockElement = document.getElementById('sys-clock');
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const ms = String(Math.floor(now.getMilliseconds() / 10)).padStart(2, '0');
        if (clockElement) clockElement.textContent = `${h}:${m}:${s}:${ms}`;
    }
    setInterval(updateClock, 47);

    // 2. TERMINAL DE LOGS
    const logBox = document.getElementById('terminal-logs');
    function addLog() {
        if (!logBox) return;
        const newLog = document.createElement('div');
        const actions = ["PING", "FETCH", "DECRYPT", "AUTH", "TRACE"];
        const action = actions[Math.floor(Math.random() * actions.length)];
        const hex = Math.floor(Math.random()*16777215).toString(16).toUpperCase().padStart(6, '0');
        
        newLog.textContent = `> ${action} 0x${hex} ... [OK]`;
        logBox.prepend(newLog);

        if (logBox.children.length > 15) {
            logBox.removeChild(logBox.lastChild);
        }
    }
    setInterval(addLog, 400);

    // 3. SISTEMA DE ABAS (Tabs)
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            const targetId = btn.getAttribute('data-tab');
            document.getElementById(targetId).classList.add('active');
        });
    });

    // 4. TRADUÇÃO DINÂMICA (i18n)
    const translations = {
        pt: {
            conn_status: "CONEXÃO SEGURA ESTABELECIDA // V 9.0", uplink_secure: "UPLINK ATIVO",
            tab_db: "[ ] MATRIZ DE DADOS", tab_add: "[+] NOVO UPLINK", tab_config: "[*] CONFIGS",
            th_name: "IDENTIFICAÇÃO ALVO", th_email: "SINAL (E-MAIL)", th_course: "VETOR (CURSO)", th_cmd: "COMANDOS",
            form_title: "INICIALIZAR INSERÇÃO DE DADOS", label_name: "> NOME_DO_OPERADOR", label_email: "> ENDERECO_SINAL (E-MAIL)", label_course: "> CHAVE_VETOR (CURSO)", btn_uplink: "EXECUTE_UPLINK",
            settings_header: "PREFERÊNCIAS DE SISTEMA", theme_select: "> ESQUEMA_DE_NÚCLEO (TEMA)", theme_dark: "OBSIDIAN_DARK", theme_light: "PHOSPHOR_LIGHT", lang_select: "> CÓDIGO_IDIOMA (LANGUAGE)", layout_select: "> ARQUITETURA DO SISTEMA",
            modal_title: "PURGA DE SISTEMA SOLICITADA", modal_text: "Confirma a aniquilação permanente dos dados?", btn_abort: "ABORTAR", btn_confirm: "CONFIRMAR"
        },
        en: {
            conn_status: "SECURE UPLINK ESTABLISHED // V 9.0", uplink_secure: "UPLINK ONLINE",
            tab_db: "[ ] DATABASE MATRIX", tab_add: "[+] NEW UPLINK", tab_config: "[*] SETTINGS",
            th_name: "TARGET IDENTIFICATION", th_email: "SIGNAL (E-MAIL)", th_course: "VECTOR (COURSE)", th_cmd: "COMMANDS",
            form_title: "INITIALIZE DATA INSERT", label_name: "> OPERATOR_NAME", label_email: "> SIGNAL_ADDRESS (E-MAIL)", label_course: "> VECTOR_KEY (COURSE)", btn_uplink: "EXECUTE_UPLINK",
            settings_header: "SYSTEM PREFERENCES", theme_select: "> CORE_SCHEMA (THEME)", theme_dark: "OBSIDIAN_DARK", theme_light: "PHOSPHOR_LIGHT", lang_select: "> LANGUAGE_CODE", layout_select: "> SYSTEM ARCHITECTURE",
            modal_title: "SYSTEM PURGE REQUESTED", modal_text: "Confirm permanent data annihilation?", btn_abort: "ABORT", btn_confirm: "CONFIRM_DEL"
        },
        es: {
            conn_status: "CONEXIÓN SEGURA ESTABLECIDA // V 9.0", uplink_secure: "UPLINK ACTIVO",
            tab_db: "[ ] MATRIZ DE DATOS", tab_add: "[+] NUEVO UPLINK", tab_config: "[*] CONFIGS",
            th_name: "IDENTIFICACIÓN OBJETIVO", th_email: "SEÑAL (E-MAIL)", th_course: "VECTOR (CURSO)", th_cmd: "COMANDOS",
            form_title: "INICIALIZAR INSERCIÓN DE DATOS", label_name: "> NOMBRE_OPERADOR", label_email: "> DIRECCIÓN_SEÑAL (E-MAIL)", label_course: "> CLAVE_VECTOR (CURSO)", btn_uplink: "EJECUTAR_UPLINK",
            settings_header: "PREFERENCIAS DE SISTEMA", theme_select: "> ESQUEMA_NÚCLEO (TEMA)", theme_dark: "OBSIDIAN_DARK", theme_light: "PHOSPHOR_LIGHT", lang_select: "> CÓDIGO_IDIOMA (LANGUAGE)", layout_select: "> ARQUITECTURA DEL SISTEMA",
            modal_title: "PURGA DE SISTEMA SOLICITADA", modal_text: "¿Confirma la aniquilación de los datos?", btn_abort: "ABORTO", btn_confirm: "CONFIRMAR"
        }
    };

    function updateLanguage(lang) {
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang][key]) el.textContent = translations[lang][key];
        });
        localStorage.setItem('aegis-lang', lang);
    }

    // 5. TROCA DE TEMA
    function updateTheme(theme) {
        document.body.classList.toggle('light-theme', theme === 'light');
        localStorage.setItem('aegis-theme', theme);
    }

    const langSelector = document.getElementById('lang-selector');
    const themeSelector = document.getElementById('theme-selector');
    const layoutSelector = document.getElementById('layout-selector');

    if(langSelector) langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    if(themeSelector) themeSelector.addEventListener('change', e => updateTheme(e.target.value));

    // O GRANDE TRUQUE DO ROTEAMENTO (Muda a interface toda)
    if(layoutSelector) {
        const currentLayout = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'omni';
        layoutSelector.value = currentLayout;
        
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload(); 
        });
    }

    // Carregar configurações iniciais salvas
    const savedLang = localStorage.getItem('aegis-lang') || 'pt';
    const savedTheme = localStorage.getItem('aegis-theme') || 'dark';
    if(langSelector) langSelector.value = savedLang;
    if(themeSelector) themeSelector.value = savedTheme;
    updateLanguage(savedLang);
    updateTheme(savedTheme);

    // 6. MODAL DE EXCLUSÃO
    const modal = document.getElementById('deleteModal');
    let delUrl = ''; 
    document.querySelectorAll('.custom-delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); 
            delUrl = this.getAttribute('href'); 
            modal.classList.add('active'); 
        });
    });
    const btnCancel = document.getElementById('btnCancelDelete');
    if (btnCancel) btnCancel.onclick = () => modal.classList.remove('active'); 
    const btnConfirm = document.getElementById('btnConfirmDelete');
    if (btnConfirm) btnConfirm.onclick = () => window.location.href = delUrl; 
});