document.addEventListener("DOMContentLoaded", () => {
    
    // ==========================================
    // 1. ENGINE DE TRADUÇÃO (i18n)
    // ==========================================
    const translations = {
        pt: {
            nav_apps: "Aplicações", nav_system: "Sistema", menu_overview: "Visão Geral", menu_directory: "Diretório", menu_add: "Novo Registro", menu_settings: "Configurações",
            overview_title: "Visão Geral", overview_sub: "Monitoramento em tempo real.", sys_online: "SISTEMA ONLINE",
            stat_volume: "VOLUME DE DADOS", stat_integrity: "INTEGRIDADE", stat_latency: "LATÊNCIA MÉDIA",
            activity_map: "Mapa de Atividade", dir_title: "Diretório", dir_sub: "Gerenciamento de credenciais.", search_placeholder: "Pesquisar...",
            th_name: "NOME / CONTATOS ↕", th_email: "E-MAIL", th_course: "CURSO ↕", th_cmd: "AÇÕES", btn_edit: "Editar", btn_del: "Apagar",
            add_title: "Novo Operador", label_name: "Nome Completo", label_course: "Curso Vinculado", btn_save: "Processar Cadastro",
            settings_title: "Configurações do Sistema", visual_prefs: "Preferências Visuais",
            theme_select: "Tema", opt_dark: "Escuro OLED", opt_light: "Claro Minimal", lang_select: "Idioma", layout_select: "Arquitetura do Sistema",
            diag_title: "Status de Segurança", diag_xss: "Prevenção XSS", diag_sql: "SQL Injection", diag_active: "Ativa",
            modal_confirm: "Confirmar Exclusão", modal_text: "Esta ação é permanente.", btn_cancel: "Cancelar", btn_del_confirm: "Excluir"
        },
        en: {
            nav_apps: "Applications", nav_system: "System", menu_overview: "Overview", menu_directory: "Directory", menu_add: "New Entry", menu_settings: "Settings",
            overview_title: "Overview", overview_sub: "Real-time monitoring.", sys_online: "SYSTEM ONLINE",
            stat_volume: "DATA VOLUME", stat_integrity: "INTEGRITY", stat_latency: "AVG LATENCY",
            activity_map: "Activity Map", dir_title: "Directory", dir_sub: "Credential management.", search_placeholder: "Search...",
            th_name: "NAME / CONTACT ↕", th_email: "E-MAIL", th_course: "COURSE ↕", th_cmd: "ACTIONS", btn_edit: "Edit", btn_del: "Delete",
            add_title: "New Operator", label_name: "Full Name", label_course: "Linked Course", btn_save: "Process Registration",
            settings_title: "System Settings", visual_prefs: "Visual Preferences",
            theme_select: "Theme", opt_dark: "Dark OLED", opt_light: "Light Minimal", lang_select: "Language", layout_select: "System Architecture",
            diag_title: "Security Status", diag_xss: "XSS Prevention", diag_sql: "SQL Injection", diag_active: "Active",
            modal_confirm: "Confirm Deletion", modal_text: "This action cannot be undone.", btn_cancel: "Cancel", btn_del_confirm: "Delete"
        },
        es: {
            nav_apps: "Aplicaciones", nav_system: "Sistema", menu_overview: "Resumen", menu_directory: "Directorio", menu_add: "Nuevo Registro", menu_settings: "Configuraciones",
            overview_title: "Resumen", overview_sub: "Monitoreo en tiempo real.", sys_online: "SISTEMA EN LÍNEA",
            stat_volume: "VOLUMEN DE DATOS", stat_integrity: "INTEGRIDAD", stat_latency: "LATENCIA MEDIA",
            activity_map: "Mapa de Actividad", dir_title: "Directorio", dir_sub: "Gestión de credenciales.", search_placeholder: "Buscar...",
            th_name: "NOMBRE / CONTACTO ↕", th_email: "E-MAIL", th_course: "CURSO ↕", th_cmd: "ACCIONES", btn_edit: "Editar", btn_del: "Borrar",
            add_title: "Nuevo Operador", label_name: "Nombre Completo", label_course: "Curso Vinculado", btn_save: "Procesar Registro",
            settings_title: "Configuraciones del Sistema", visual_prefs: "Preferencias Visuales",
            theme_select: "Tema", opt_dark: "Oscuro OLED", opt_light: "Claro Minimal", lang_select: "Idioma", layout_select: "Arquitectura del Sistema",
            diag_title: "Estado de Seguridad", diag_xss: "Prevención XSS", diag_sql: "Inyección SQL", diag_active: "Activa",
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

    const langSelector = document.getElementById('lang-selector');
    if(langSelector) {
        langSelector.value = currentLang;
        langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    }
    updateLanguage(currentLang);

    // ==========================================
    // 2. SISTEMA DE TOASTS DO SERVIDOR
    // ==========================================
    const toastEl = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-msg');
    
    window.showToast = (msg, isError = false) => {
        if(toastEl) {
            toastMsg.textContent = msg;
            toastEl.style.borderLeft = isError ? "4px solid var(--danger)" : "4px solid var(--success)";
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 4000);
        }
    };

    if (typeof serverToastSuccess !== 'undefined' && serverToastSuccess !== '') showToast(serverToastSuccess, false);
    if (typeof serverToastError !== 'undefined' && serverToastError !== '') showToast(serverToastError, true);

    // ==========================================
    // 3. MÁSCARAS DE INPUT
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
    // 4. GRÁFICO DINÂMICO (Chart.js)
    // ==========================================
    const chartCanvas = document.getElementById('courseChart');
    if (chartCanvas && typeof chartLabels !== 'undefined') {
        new Chart(chartCanvas, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#34D399', '#3B82F6', '#F59E0B', '#8B5CF6'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom', labels: { color: '#A1A1AA' } } }
            }
        });
    }

    // ==========================================
    // 5. BUSCA GLOBAL INTELIGENTE (Corrigido)
    // ==========================================
    const searchInput = document.getElementById('tableSearch');
    if(searchInput) {
        searchInput.addEventListener('input', e => {
            const val = e.target.value.toLowerCase().trim();
            
            document.querySelectorAll('.enterprise-table tbody tr.table-row').forEach(row => {
                // Lê o conteúdo de toda a linha (permite buscar por ID, Nome, Email ou Curso)
                const rowText = row.textContent.toLowerCase();
                const matchFound = rowText.includes(val);
                
                // Exibe ou esconde a linha baseada na busca global
                row.style.display = matchFound ? '' : 'none';

                // Aplica o efeito visual de highlight no nome, se houver match lá
                const nameCell = row.querySelector('.highlight-target');
                if(nameCell) {
                    const originalText = nameCell.getAttribute('data-original') || nameCell.textContent;
                    if(!nameCell.getAttribute('data-original')) nameCell.setAttribute('data-original', originalText);

                    if (val !== "" && originalText.toLowerCase().includes(val)) {
                        const regex = new RegExp(`(${val})`, 'gi');
                        nameCell.innerHTML = originalText.replace(regex, '<mark style="background: #FBBF24; color: #000; border-radius:2px; padding:0 2px;">$1</mark>');
                    } else {
                        nameCell.innerHTML = originalText;
                    }
                }
            });
        });
    }

    // ==========================================
    // 6. ORDENAÇÃO DA TABELA (Sorting - Corrigido)
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

                // Se for a coluna de UID (posição 1 no OMNI), converte pra número
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
    // 7. NAVEGAÇÃO SPA
    // ==========================================
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

    // ==========================================
    // 8. MODAL DE EXCLUSÃO
    // ==========================================
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

    // ==========================================
    // 9. TEMAS E ROTEADOR (Troca de Arquitetura)
    // ==========================================
    function updateTheme(theme) {
        document.body.classList.toggle('light-mode', theme === 'light');
        localStorage.setItem('omni-theme', theme);
    }
    
    const themeSelector = document.getElementById('theme-selector');
    const savedTheme = localStorage.getItem('omni-theme') || 'dark';
    if(themeSelector) {
        themeSelector.value = savedTheme;
        themeSelector.addEventListener('change', e => updateTheme(e.target.value));
    }
    updateTheme(savedTheme);
    
    const layoutSelector = document.getElementById('layout-selector');
    if(layoutSelector) {
        const currentLayout = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'omni';
        layoutSelector.value = currentLayout;
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload(); 
        });
    }

    // Efeito Spotlight do Cursor
    document.addEventListener('mousemove', e => {
        document.querySelectorAll('.bionic-card').forEach(card => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
            card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
        });
    });
});