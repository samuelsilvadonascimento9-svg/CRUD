document.addEventListener("DOMContentLoaded", () => {
    
    // ==========================================
    // 1. SISTEMA DE TOASTS DO SERVIDOR
    // ==========================================
    const toastEl = document.getElementById('quantum-toast');
    const toastMsg = document.getElementById('quantum-toast-msg');
    
    function showToast(msg, isError = false) {
        if(toastEl) {
            toastMsg.textContent = msg;
            toastEl.style.borderColor = isError ? "var(--danger)" : "var(--liquid-accent)";
            toastEl.style.color = isError ? "var(--danger)" : "#FFF";
            toastEl.style.bottom = "50px"; // Anima para cima
            setTimeout(() => toastEl.style.bottom = "-100px", 4000);
        }
    }

    if (typeof serverToastSuccess !== 'undefined' && serverToastSuccess !== '') showToast(serverToastSuccess, false);
    if (typeof serverToastError !== 'undefined' && serverToastError !== '') showToast(serverToastError, true);

    // ==========================================
    // 2. MÁSCARAS DE INPUT
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
    // 3. GRÁFICO (Chart.js) COM TEMA QUANTUM
    // ==========================================
    const chartCanvas = document.getElementById('courseChart');
    if (chartCanvas && typeof chartLabels !== 'undefined') {
        Chart.defaults.color = '#FFF';
        Chart.defaults.font.family = "'Space Mono', monospace";
        new Chart(chartCanvas, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#00F0FF', '#7000FF', '#FF0055', '#FFFFFF'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } } // Oculta a legenda para caber no mini-painel
            }
        });
    }

    // ==========================================
    // 4. BUSCA GLOBAL INTELIGENTE 
    // ==========================================
    const searchInput = document.getElementById('tableSearch');
    if(searchInput) {
        searchInput.addEventListener('input', e => {
            const val = e.target.value.toLowerCase().trim();
            
            document.querySelectorAll('.quantum-table tbody tr.table-row').forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const matchFound = rowText.includes(val);
                row.style.display = matchFound ? '' : 'none';

                const nameCell = row.querySelector('.highlight-target');
                if(nameCell) {
                    const originalText = nameCell.getAttribute('data-original') || nameCell.textContent;
                    if(!nameCell.getAttribute('data-original')) nameCell.setAttribute('data-original', originalText);

                    if (val !== "" && originalText.toLowerCase().includes(val)) {
                        const regex = new RegExp(`(${val})`, 'gi');
                        nameCell.innerHTML = originalText.replace(regex, '<mark style="background: var(--liquid-accent); color: #000; padding: 0 2px; border-radius: 2px;">$1</mark>');
                    } else {
                        nameCell.innerHTML = originalText;
                    }
                }
            });
        });
    }

    // ==========================================
    // 5. ORDENAÇÃO DA TABELA (Sorting)
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
    // 6. GERENCIADOR DE JANELAS (Spatial OS)
    // ==========================================
    let zIndexCounter = 10;
    const windows = document.querySelectorAll('.spatial-window');
    
    windows.forEach(win => {
        const bar = win.querySelector('.window-bar');
        if(!bar) return;

        // Traz janela para frente ao clicar
        win.addEventListener('mousedown', () => {
            zIndexCounter++;
            win.style.zIndex = zIndexCounter;
        });

        // Lógica de arrastar
        let isDragging = false, startX, startY, initialX, initialY;
        bar.addEventListener('mousedown', e => {
            if(e.target.closest('.window-controls')) return;
            isDragging = true;
            startX = e.clientX; startY = e.clientY;
            initialX = win.offsetLeft; initialY = win.offsetTop;
            win.style.transition = 'none';
        });

        document.addEventListener('mousemove', e => {
            if(!isDragging) return;
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;
            win.style.left = `${initialX + dx}px`;
            win.style.top = `${initialY + dy}px`;
        });

        document.addEventListener('mouseup', () => {
            if(isDragging) {
                isDragging = false;
                win.style.transition = 'transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s';
            }
        });

        // Fechar / Minimizar
        const closeBtn = win.querySelector('.close-btn');
        const minBtn = win.querySelector('.minimize-btn');
        
        if(closeBtn) {
            closeBtn.addEventListener('click', () => {
                win.classList.remove('active');
                updateDock();
            });
        }
        if(minBtn) {
            minBtn.addEventListener('click', () => {
                win.classList.remove('active');
                updateDock();
            });
        }
    });

    // ==========================================
    // 7. DOCK DE APLICATIVOS
    // ==========================================
    const dockIcons = document.querySelectorAll('.dock-icon');
    
    function updateDock() {
        dockIcons.forEach(icon => {
            const targetId = icon.getAttribute('data-target');
            const targetWin = document.getElementById(targetId);
            if(targetWin && targetWin.classList.contains('active')) {
                icon.classList.add('active');
            } else {
                icon.classList.remove('active');
            }
        });
    }

    dockIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const targetId = icon.getAttribute('data-target');
            const targetWin = document.getElementById(targetId);
            if(targetWin) {
                if(targetWin.classList.contains('active')) {
                    // Minimiza se já estiver ativo
                    targetWin.classList.remove('active');
                } else {
                    // Traz para frente e exibe
                    zIndexCounter++;
                    targetWin.style.zIndex = zIndexCounter;
                    targetWin.classList.add('active');
                }
                updateDock();
            }
        });
    });

    // ==========================================
    // 8. MODAL DE EXCLUSÃO
    // ==========================================
    const modal = document.getElementById('deleteModal');
    let delUrl = '';
    document.querySelectorAll('.custom-delete-trigger').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            delUrl = this.getAttribute('data-href');
            zIndexCounter++;
            modal.style.zIndex = zIndexCounter + 10;
            modal.classList.add('active');
        });
    });
    const btnCancel = document.getElementById('btnCancelDelete');
    if(btnCancel) btnCancel.onclick = () => modal.classList.remove('active');
    const btnConfirm = document.getElementById('btnConfirmDelete');
    if(btnConfirm) btnConfirm.onclick = () => window.location.href = delUrl;

    // ==========================================
    // 9. IDIOMA E TEMAS (TRADUÇÕES)
    // ==========================================
    const translations = {
        pt: {
            add_title: "TERMINAL DE ENTRADA v.4.0", label_name: "IDENTIFICAÇÃO DO OPERADOR", label_email: "CANAL DE COMUNICAÇÃO (E-MAIL)", label_course: "VETOR DE ACESSO (CURSO)", btn_save: "PROCESSAR DADOS",
            dir_title: "VISUALIZADOR DE MATRIZ", th_name: "Operador / Contato ↕", th_course: "Vetor ↕", th_cmd: "Controle",
            settings_title: "PREFERÊNCIAS DE SISTEMA", lang_select: "IDIOMA DO SISTEMA", theme_select: "ESQUEMA DE CORES", layout_select: "ARQUITETURA DO SISTEMA",
            modal_confirm: "Confirmar Purga de Dados?", modal_text: "Esta operação es irreversível.", btn_cancel: "CANCELAR", btn_confirm: "CONFIRMAR PURGA"
        },
        en: {
            add_title: "INPUT TERMINAL v.4.0", label_name: "OPERATOR IDENTIFICATION", label_email: "COMMUNICATION CHANNEL (E-MAIL)", label_course: "ACCESS VECTOR (COURSE)", btn_save: "PROCESS DATA",
            dir_title: "MATRIX VIEWER", th_name: "Operator / Contact ↕", th_course: "Vector ↕", th_cmd: "Control",
            settings_title: "SYSTEM PREFERENCES", lang_select: "SYSTEM LANGUAGE", theme_select: "COLOR SCHEME", layout_select: "SYSTEM ARCHITECTURE",
            modal_confirm: "Confirm Data Purge?", modal_text: "This operation is irreversible.", btn_cancel: "CANCEL", btn_confirm: "CONFIRM PURGE"
        },
        es: {
            add_title: "TERMINAL DE ENTRADA v.4.0", label_name: "IDENTIFICACIÓN DEL OPERADOR", label_email: "CANAL DE COMUNICACIÓN (E-MAIL)", label_course: "VECTOR DE ACCESO (CURSO)", btn_save: "PROCESAR DATOS",
            dir_title: "VISOR DE MATRIZ", th_name: "Operador / Contacto ↕", th_course: "Vector ↕", th_cmd: "Control",
            settings_title: "PREFERENCIAS DEL SISTEMA", lang_select: "IDIOMA DEL SISTEMA", theme_select: "ESQUEMA DE COLORES", layout_select: "ARQUITECTURA DEL SISTEMA",
            modal_confirm: "¿Confirmar Purga de Datos?", modal_text: "Esta operación es irreversible.", btn_cancel: "CANCELAR", btn_confirm: "CONFIRMAR PURGA"
        }
    };

    let currentLang = localStorage.getItem('quantum-lang') || 'pt';
    function updateLanguage(lang) {
        currentLang = lang;
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) el.textContent = translations[lang][key];
        });
        localStorage.setItem('quantum-lang', lang);
    }

    function updateTheme(theme) {
        document.body.classList.toggle('light-theme', theme === 'light');
        localStorage.setItem('quantum-theme', theme);
    }

    const langSelector = document.getElementById('lang-selector');
    if(langSelector) {
        langSelector.value = currentLang;
        langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    }
    
    const themeSelector = document.getElementById('theme-selector');
    if(themeSelector) {
        themeSelector.value = localStorage.getItem('quantum-theme') || 'dark';
        themeSelector.addEventListener('change', e => updateTheme(e.target.value));
    }
    updateTheme(themeSelector ? themeSelector.value : 'dark');
    updateLanguage(currentLang);

    const layoutSelector = document.getElementById('layout-selector');
    if(layoutSelector) {
        layoutSelector.value = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'quantum';
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload(); 
        });
    }

    // Efeito magnético de fundo
    document.addEventListener('mousemove', e => {
        const blobs = document.querySelectorAll('.liquid-blob');
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        blobs[0].style.transform = `translate(${mouseX * 50}px, ${mouseY * 50}px) scale(1.1)`;
        blobs[1].style.transform = `translate(${mouseX * -30}px, ${mouseY * -30}px) scale(0.9)`;
    });
});