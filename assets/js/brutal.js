document.addEventListener("DOMContentLoaded", () => {

    // ==========================================
    // 0. CÂMERA DE PANNING (NOVO EFEITO)
    // ==========================================
    const canvasPan = document.getElementById('canvasPan');
    const btnGoLeft = document.getElementById('btnGoLeft');
    const btnGoRight = document.getElementById('btnGoRight');
    const btnsGoCenter = document.querySelectorAll('.btn-go-center');

    // Desliza a câmera (A propriedade transition já está no CSS para suavizar)
    if(btnGoLeft) btnGoLeft.addEventListener('click', () => canvasPan.style.transform = 'translateX(0%)'); // Move tudo pra direita (Mostra painel esquerdo)
    if(btnGoRight) btnGoRight.addEventListener('click', () => canvasPan.style.transform = 'translateX(-66.666%)'); // Move tudo pra esquerda (Mostra painel direito)
    
    // Botões de voltar
    btnsGoCenter.forEach(btn => {
        btn.addEventListener('click', () => canvasPan.style.transform = 'translateX(-33.333%)'); // Centraliza
    });


    // ==========================================
    // 1. SISTEMA DE TOASTS DO SERVIDOR
    // ==========================================
    const toastEl = document.getElementById('brutal-toast');
    const toastMsg = document.getElementById('brutal-toast-msg');
    
    function showToast(msg, isError = false) {
        if(toastEl) {
            toastMsg.textContent = msg.toUpperCase(); 
            toastEl.style.background = isError ? "#FF4949" : "#4ade80"; 
            toastEl.style.color = "#000";
            toastEl.style.bottom = "40px";
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
    // 3. GRÁFICO (Chart.js) COM TEMA BRUTALISTA
    // ==========================================
    const chartCanvas = document.getElementById('courseChart');
    if (chartCanvas && typeof chartLabels !== 'undefined') {
        Chart.defaults.color = '#000';
        Chart.defaults.font.family = "'Space Mono', monospace";
        Chart.defaults.font.weight = 'bold';
        
        new Chart(chartCanvas, {
            type: 'pie',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#FF90E8', '#FFC900', '#22C55E', '#3B82F6'],
                    borderColor: '#000', 
                    borderWidth: 4,
                    hoverOffset: 10
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } } // Desativei a legenda pra o gráfico ficar bem grande e visual
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
            
            document.querySelectorAll('.neo-table tbody tr.table-row').forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const matchFound = rowText.includes(val);
                row.style.display = matchFound ? '' : 'none';

                const nameCell = row.querySelector('.highlight-target');
                if(nameCell) {
                    const originalText = nameCell.getAttribute('data-original') || nameCell.textContent;
                    if(!nameCell.getAttribute('data-original')) nameCell.setAttribute('data-original', originalText);

                    if (val !== "" && originalText.toLowerCase().includes(val)) {
                        const regex = new RegExp(`(${val})`, 'gi');
                        nameCell.innerHTML = originalText.replace(regex, '<mark style="background: #000; color: #FFF; padding: 2px 4px;">$1</mark>');
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
    // 6. IDIOMA E ROTEADOR (TRADUÇÕES)
    // ==========================================
    const translations = {
        pt: {
            add_title: "ENTRADA", label_name: "NOME DO OPERADOR", label_email: "E-MAIL DE CONTATO", label_course: "CURSO VINCULADO", btn_save: "CADASTRAR DADOS",
            dir_title: "MATRIZ DE USUÁRIOS", th_name: "OPERADOR ↕", th_course: "CURSO ↕", th_cmd: "AÇÕES",
            settings_title: "CONFIGS", lang_select: "IDIOMA", layout_select: "ARQUITETURA",
            modal_title: "AVISO CRÍTICO", modal_text: "Você tem certeza que deseja excluir este operador da base de dados? Isso não pode ser desfeito.", btn_abort: "CANCELAR", btn_confirm: "EXCLUIR"
        },
        en: {
            add_title: "INPUT", label_name: "OPERATOR NAME", label_email: "CONTACT E-MAIL", label_course: "LINKED COURSE", btn_save: "REGISTER DATA",
            dir_title: "USER MATRIX", th_name: "OPERATOR ↕", th_course: "COURSE ↕", th_cmd: "ACTIONS",
            settings_title: "SETTINGS", lang_select: "LANGUAGE", layout_select: "ARCHITECTURE",
            modal_title: "CRITICAL WARNING", modal_text: "Are you sure you want to delete this operator from the database? This cannot be undone.", btn_abort: "CANCEL", btn_confirm: "DELETE"
        },
        es: {
            add_title: "ENTRADA", label_name: "NOMBRE DEL OPERADOR", label_email: "E-MAIL DE CONTACTO", label_course: "CURSO VINCULADO", btn_save: "REGISTRAR DATOS",
            dir_title: "MATRIZ DE USUARIOS", th_name: "OPERADOR ↕", th_course: "CURSO ↕", th_cmd: "ACCIONES",
            settings_title: "CONFIGS", lang_select: "IDIOMA", layout_select: "ARQUITECTURA",
            modal_title: "AVISO CRÍTICO", modal_text: "¿Estás seguro de que deseas eliminar este operador de la base de datos? Esto no se puede deshacer.", btn_abort: "CANCELAR", btn_confirm: "ELIMINAR"
        }
    };

    let currentLang = localStorage.getItem('brutal-lang') || 'pt';
    function updateLanguage(lang) {
        currentLang = lang;
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) el.textContent = translations[lang][key];
        });
        localStorage.setItem('brutal-lang', lang);
    }

    const langSelector = document.getElementById('lang-selector');
    if(langSelector) {
        langSelector.value = currentLang;
        langSelector.addEventListener('change', e => updateLanguage(e.target.value));
    }
    updateLanguage(currentLang);

    const layoutSelector = document.getElementById('layout-selector');
    if(layoutSelector) {
        layoutSelector.value = document.cookie.split('; ').find(row => row.startsWith('system_layout='))?.split('=')[1] || 'brutal';
        layoutSelector.addEventListener('change', e => {
            document.cookie = `system_layout=${e.target.value}; path=/; max-age=${30*24*60*60}`;
            window.location.reload(); 
        });
    }

    // ==========================================
    // 7. MODAL DE EXCLUSÃO
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