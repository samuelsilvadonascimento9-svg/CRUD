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
    setInterval(updateClock, 47); // Atualiza rapidinho pelos milisegundos

    // 2. TERMINAL DE LOGS (Hacker Text Effect)
    const logBox = document.getElementById('terminal-logs');
    function generateHex() {
        return Math.floor(Math.random()*16777215).toString(16).toUpperCase().padStart(6, '0');
    }
    function addLog() {
        if (!logBox) return;
        const newLog = document.createElement('div');
        // Adiciona mensagens com cara de sistema
        const actions = ["PING", "FETCH", "DECRYPT", "AUTH", "TRACE"];
        const action = actions[Math.floor(Math.random() * actions.length)];
        
        newLog.textContent = `> ${action} 0x${generateHex()} ... [OK]`;
        logBox.prepend(newLog); // Joga no topo (a div tem column-reverse)

        // Mantém só os últimos 15 logs pra não pesar a tela
        if (logBox.children.length > 15) {
            logBox.removeChild(logBox.lastChild);
        }
    }
    setInterval(addLog, 400); // Gera um log a cada 400ms

    // 3. SISTEMA DE ABAS (Tabs Navigation)
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active de todos
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            // Adiciona ativo no clicado
            btn.classList.add('active');
            const targetId = btn.getAttribute('data-tab');
            document.getElementById(targetId).classList.add('active');
        });
    });

    // 4. MODAL DE EXCLUSÃO
    const deleteButtons = document.querySelectorAll('.custom-delete-btn');
    const modalOverlay = document.getElementById('deleteModal');
    const btnCancel = document.getElementById('btnCancelDelete');
    const btnConfirm = document.getElementById('btnConfirmDelete');
    let deleteUrl = ''; 

    if (modalOverlay) {
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); 
                deleteUrl = this.getAttribute('href'); 
                modalOverlay.classList.add('active'); 
            });
        });

        btnCancel.addEventListener('click', () => {
            modalOverlay.classList.remove('active'); 
        });

        btnConfirm.addEventListener('click', () => {
            window.location.href = deleteUrl; 
        });
    }
});