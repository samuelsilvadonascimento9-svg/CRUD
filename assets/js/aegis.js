document.addEventListener("DOMContentLoaded", () => {
    
    // ==========================================
    // 1. RELÓGIO DO SISTEMA TÁTICO
    // ==========================================
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

    // ==========================================
    // 2. TERMINAL DE LOGS
    // ==========================================
    const logBox = document.getElementById('terminal-logs');
    function addLog() {
        if (!logBox) return;
        const newLog = document.createElement('div');
        const actions = ["PING", "FETCH", "DECRYPT", "AUTH", "TRACE", "SCAN", "UPLINK"];
        const action = actions[Math.floor(Math.random() * actions.length)];
        const hex = Math.floor(Math.random()*16777215).toString(16).toUpperCase().padStart(6, '0');
        newLog.textContent = `> ${action} 0x${hex} ... [OK]`;
        logBox.prepend(newLog);
        if (logBox.children.length > 15) logBox.removeChild(logBox.lastChild);
    }
    setInterval(addLog, 400);

    // ==========================================
    // 3. TOASTS DO SERVIDOR
    // ==========================================
    const toastEl = document.getElementById('aegis-toast');
    const toastMsg = document.getElementById('aegis-toast-msg');
    function showToast(msg, isError = false) {
        if(toastEl) {
            toastMsg.textContent = msg;
            if(isError) {
                toastEl.style.borderColor = "var(--danger)";
                toastEl.style.color = "var(--danger)";
                toastEl.style.background = "rgba(255,0,60,0.1)";
            } else {
                toastEl.style.borderColor = "var(--neon-green)";
                toastEl.style.color = "var(--neon-green)";
                toastEl.style.background = "rgba(0,255,65,0.1)";
            }
            toastEl.style.bottom = "40px";
            setTimeout(() => toastEl.style.bottom = "-100px", 4000);
        }
    }
    if (typeof serverToastSuccess !== 'undefined' && serverToastSuccess !== '') showToast(serverToastSuccess, false);
    if (typeof serverToastError !== 'undefined' && serverToastError !== '') showToast(serverToastError, true);

    // ==========================================
    // 4. MÁSCARAS DE INPUT
    // ==========================================
    const cpfInput = document.getElementById('cpfMask');
    if (cpfInput) {
        cpfInput.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v.substring(0, 14);
        });
    }
    const phoneInput = document.getElementById('phoneMask');
    if (phoneInput) {
        phoneInput.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
            v = v.replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = v.substring(0, 15);
        });
    }

    // ==========================================
    // 5. GRÁFICO (Chart.js) COM TEMA HACKER
    // ==========================================
    const chartCanvas = document.getElementById('courseChart');
    if (chartCanvas && typeof chartLabels !== 'undefined') {
        Chart.defaults.color = '#00FF41';
        Chart.defaults.font.family = "'Share Tech Mono', monospace";
        new Chart(chartCanvas, {
            type: 'pie',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: ['rgba(0, 255, 65, 0.8)', 'rgba(0, 143, 17, 0.8)', 'rgba(125, 166, 139, 0.8)', 'rgba(2, 6, 8, 0.8)'],
                    borderColor: '#00FF41',
                    borderWidth: 1,
                    hoverOffset: 5
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }

    // ==========================================
    // 6. BUSCA GLOBAL INTELIGENTE (Corrigido)
    // ==========================================
    const searchInput = document.getElementById('tableSearch');
    if(searchInput) {
        searchInput.addEventListener('input', e => {
            const val = e.target.value.toLowerCase().trim();
            
            document.querySelectorAll('.aegis-table tbody tr.table-row').forEach(row => {
                // Lê todo o texto da linha (ID, Nome, Email, Fone, Curso)
                const rowText = row.textContent.toLowerCase();
                const matchFound = rowText.includes(val);
                
                // Exibe ou esconde a linha baseada na busca global
                row.style.display = matchFound ? '' : 'none';

                // Aplica o efeito visual de highlight apenas se o texto digitado estiver no nome
                const nameCell = row.querySelector('.highlight-target');
                if(nameCell) {
                    const originalText = nameCell.getAttribute('data-original') || nameCell.textContent;
                    if(!nameCell.getAttribute('data-original')) nameCell.setAttribute('data-original', originalText);

                    if (val !== "" && originalText.toLowerCase().includes(val)) {
                        const regex = new RegExp(`(${val})`, 'gi');
                        nameCell.innerHTML = originalText.replace(regex, '<mark style="background: var(--neon-green); color: var(--bg-dark); padding: 0 2px; border-radius: 2px;">$1</mark>');
                    } else {
                        nameCell.innerHTML = originalText;
                    }
                }
            });
        });
    }

    // ==========================================
    // 7. ORDENAÇÃO DA TABELA
    // ==========================================
    document.querySelectorAll('th.sortable').forEach(th => {
        th.addEventListener('click', function() {
            const table = th.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr.table-row'));
            const index = Array.from(th.parentElement.children).indexOf(th);
            
            const isAscending = th.classList.contains('asc');

            document.querySelectorAll('th.sortable').forEach(h => h.classList.remove('asc', 'desc'));
            th.classList.add(isAscending ? 'desc' : 'asc');

            rows.sort((a, b) => {
                let valA = a.children[index].textContent.trim();
                let valB = b.children[index].textContent.trim();

                if (index === 1) { 
                    valA = parseInt(valA.replace(/\D/g, ''));
                    valB = parseInt(valB.replace(/\D/g, ''));
                } else {
                    valA = valA.toLowerCase();
                    valB = valB.toLowerCase();
                }

                if (valA < valB) return isAscending ? 1 : -1;
                if (valA > valB) return isAscending ? -1 : 1;
                return 0;
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });

    // ==========================================
    // 8. SISTEMA DE ABAS (Tabs)
    // ==========================================
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.getAttribute('data-tab')).classList.add('active');
        });
    });

    // ==========================================
    // 9. TRADUÇÕES (i18n)
    // ==========================================
    const translations = {
        pt: {
            conn_status: "CONEXÃO SEGURA ESTABELECIDA // V 9.0", uplink_secure: "UPLINK ATIVO",
            tab_db: "[ ] MATRIZ DE DADOS", tab_add: "[+] NOVO UPLINK", tab_config: "[*] CONFIGS",
            th_name: "IDENTIFICAÇÃO ALVO ↕", th_email: "SINAL (E-MAIL)", th_course: "VETOR (CURSO) ↕", th_cmd: "COMANDOS",
            form_title: "INICIALIZAR INSERÇÃO DE DADOS", label_name: "> NOME_DO_OPERADOR", label_email: "> ENDERECO_SINAL (E-MAIL)", label_course: "> CHAVE_VETOR (CURSO)", btn_uplink: "EXECUTE_UPLINK",
            settings_header: "PREFERÊNCIAS DE SISTEMA", theme_select: "> ESQUEMA_DE_NÚCLEO (TEMA)", theme_dark: "OBSIDIAN_DARK", theme_light: "PHOSPHOR_LIGHT", lang_select: "> CÓDIGO_IDIOMA (LANGUAGE)", layout_select: "> ARQUITETURA DO SISTEMA",
            modal_title: "PURGA DE SISTEMA SOLICITADA", modal_text: "Confirma a aniquilação permanente dos dados?", btn_abort: "ABORTAR", btn_confirm: "CONFIRMAR"
        },
        en: {
            conn_status: "SECURE UPLINK ESTABLISHED // V 9.0", uplink_secure: "UPLINK ONLINE",
            tab_db: "[ ] DATABASE MATRIX", tab_add: "[+] NEW UPLINK", tab_config: "[*] SETTINGS",
            th_name: "TARGET IDENTIFICATION ↕", th_email: "SIGNAL (E-MAIL)", th_course: "VECTOR (COURSE) ↕", th_cmd: "COMMANDS",
            form_title: "INITIALIZE DATA INSERT", label_name: "> OPERATOR_NAME", label_email: "> SIGNAL_ADDRESS (E-MAIL)", label_course: "> VECTOR_KEY (COURSE)", btn_uplink: "EXECUTE_UPLINK",
            settings_header: "SYSTEM PREFERENCES", theme_select: "> CORE_SCHEMA (THEME)", theme_dark: "OBSIDIAN_DARK", theme_light: "PHOSPHOR_LIGHT", lang_select: "> LANGUAGE_CODE", layout_select: "> SYSTEM ARCHITECTURE",
            modal_title: "SYSTEM PURGE REQUESTED", modal_text: "Confirm permanent data annihilation?", btn_abort: "ABORT", btn_confirm: "CONFIRM_DEL"
        },
        es: {
            conn_status: "CONEXIÓN SEGURA ESTABLECIDA // V 9.0", uplink_secure: "UPLINK ACTIVO",
            tab_db: "[ ] MATRIZ DE DATOS", tab_add: "[+] NUEVO UPLINK", tab_config: "[*] CONFIGS",
            th_name: "IDENTIFICACIÓN OBJETIVO ↕", th_email: "SEÑAL (E-MAIL)", th_course: "VECTOR (CURSO) ↕", th_cmd: "COMANDOS",
            form_title: "INICIALIZAR INSERCIÓN DE DATOS", label_name: "> NOMBRE_OPERADOR", label_email: "> DIRECCIÓN_SEÑAL (E-MAIL)", label_course: "> CLAVE_VECTOR (CURSO)", btn_uplink: "EJECUTAR_UPLINK",
            settings_header: "PREFERENCIAS DE SISTEMA", theme_select: "> ESQUEMA_NÚCLEO (TEMA)", theme_dark: "OBSIDIAN_DARK", theme_light: "PHOSPHOR_LIGHT", lang_select: "> CÓDIGO_IDIOMA (LANGUAGE)", layout_select: "> ARQUITECTURA DEL SISTEMA",
            modal_title: "PURGA DE SISTEMA SOLICITADA", modal_text: "¿Confirma la aniquilación de los datos?", btn_abort: "ABORTO", btn_confirm: "CONFIRMAR"
        }
    };

    let currentLang = localStorage.getItem('aegis-lang') || 'pt';
    function updateLanguage(lang) {
        currentLang = lang;
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang][key]) el.textContent = translations[lang][key];
        });
        localStorage.setItem('aegis-lang', lang);
    }

    function updateTheme(theme) {
        document.body.classList.toggle('light-theme', theme === 'light');
        localStorage.setItem('aegis-theme', theme);
    }

    const langSelector = document.getElementById('lang-selector');
    const themeSelector = document.getElementById('theme-selector');
    const layoutSelector = document.getElementById('layout-selector');

    if(langSelector) {
        langSelector.value = currentLang;
        langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    }
    if(themeSelector) {
        themeSelector.value = localStorage.getItem('aegis-theme') || 'dark';
        themeSelector.addEventListener('change', e => updateTheme(e.target.value));
    }
    if(layoutSelector) {
        layoutSelector.value = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'aegis';
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload(); 
        });
    }

    updateLanguage(currentLang);
    updateTheme(themeSelector ? themeSelector.value : 'dark');

    // ==========================================
    // 10. MODAL DE EXCLUSÃO
    // ==========================================
    const modal = document.getElementById('deleteModal');
    let delUrl = ''; 
    document.querySelectorAll('.custom-delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); 
            delUrl = this.getAttribute('href'); 
            modal.classList.add('active'); 
        });
    });
    if (document.getElementById('btnCancelDelete')) document.getElementById('btnCancelDelete').onclick = () => modal.classList.remove('active'); 
    if (document.getElementById('btnConfirmDelete')) document.getElementById('btnConfirmDelete').onclick = () => window.location.href = delUrl; 
});