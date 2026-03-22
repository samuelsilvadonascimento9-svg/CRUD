document.addEventListener("DOMContentLoaded", () => {
    
    // GERENCIADOR DE JANELAS ESPACIAIS (Quantum OS Logic)
    const dockIcons = document.querySelectorAll('.dock-icon');
    const windows = document.querySelectorAll('.spatial-window:not(.modal-window)');
    let maxZIndex = 10; // Começa alto para garantir que fiquem acima

    // Função para trazer janela para frente
    function bringToFront(windowElement) {
        maxZIndex++;
        windowElement.style.zIndex = maxZIndex;
    }

    // 1. Lógica do Dock Bar (Abrir/Fechar Apps)
    dockIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const targetId = icon.getAttribute('data-target');
            const targetWindow = document.getElementById(targetId);
            
            // Toggle estado ativo do ícone e da janela
            icon.classList.toggle('active');
            targetWindow.classList.toggle('active');

            // Se abriu, traz para frente
            if (targetWindow.classList.active) {
                bringToFront(targetWindow);
            }
        });
    });

    // 2. Clique na janela traz ela para frente
    windows.forEach(win => {
        win.addEventListener('mousedown', () => {
            bringToFront(win);
        });
    });

    // 3. Botões de fechar janela (Simulação)
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            // Encontra a janela pai e fecha
            const win = e.target.closest('.spatial-window');
            win.classList.remove('active');
            // Desativa o ícone no dock correspondente
            const dockIcon = document.querySelector(`.dock-icon[data-target="${win.id}"]`);
            if (dockIcon) dockIcon.classList.remove('active');
        });
    });


    // LOGICA DO MODAL DE EXCLUSÃO (Mantida e adaptada)
    const deleteTriggers = document.querySelectorAll('.custom-delete-trigger');
    const modalOverlay = document.getElementById('deleteModal');
    const btnCancel = document.getElementById('btnCancelDelete');
    const btnConfirm = document.getElementById('btnConfirmDelete');
    let deleteUrl = ''; 

    if (modalOverlay) {
        deleteTriggers.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); 
                // Usamos data-href em vez de href para botoes
                deleteUrl = this.getAttribute('data-href'); 
                modalOverlay.classList.add('active'); 
            });
        });

        btnCancel.addEventListener('click', () => {
            modalOverlay.classList.remove('active'); 
        });

        btnConfirm.addEventListener('click', () => {
            window.location.href = deleteUrl; 
        });
        
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) modalOverlay.classList.remove('active');
        });
    }
});