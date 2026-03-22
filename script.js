document.addEventListener("DOMContentLoaded", () => {
    
    // 1. EFEITO SPOTLIGHT (BIONIC BORDERS)
    const bionicCards = document.querySelectorAll('.bionic-card');
    
    document.addEventListener('mousemove', (e) => {
        bionicCards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    });

    // 2. SISTEMA DE NAVEGAÇÃO SPA (Com suporte a Aba de Diagnóstico)
    const navItems = document.querySelectorAll('.nav-item[data-view]');
    const viewSections = document.querySelectorAll('.view-section');
    const shortcutAdd = document.getElementById('btn-shortcut-add');

    function switchView(targetViewId) {
        viewSections.forEach(view => {
            view.style.opacity = '0';
        });

        setTimeout(() => {
            navItems.forEach(nav => nav.classList.remove('active'));
            viewSections.forEach(view => view.classList.remove('active'));
            
            const targetNav = document.querySelector(`[data-view="${targetViewId}"]`);
            if (targetNav) targetNav.classList.add('active');
            
            const targetView = document.getElementById(targetViewId);
            targetView.classList.add('active');
            
            setTimeout(() => {
                targetView.style.opacity = '1';
            }, 50);
        }, 150); 
    }

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            switchView(item.getAttribute('data-view'));
        });
    });

    if (shortcutAdd) {
        shortcutAdd.addEventListener('click', () => switchView('view-insert'));
    }

    // 3. BARRA DE PESQUISA (Filtro na tabela)
    const searchInput = document.getElementById('tableSearch');
    const tableRows = document.querySelectorAll('.table-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // 4. DIALOG DE EXCLUSÃO (Modal)
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

        const closeModal = () => modalOverlay.classList.remove('active');
        btnCancel.addEventListener('click', closeModal);
        
        btnConfirm.addEventListener('click', () => {
            window.location.href = deleteUrl; 
        });

        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });
    }

    // 5. TOAST NOTIFICATION (Exposto globalmente para o form)
    window.showToast = function(message) {
        const toast = document.getElementById('toast');
        const toastMsg = document.getElementById('toast-msg');
        
        if(toast && toastMsg) {
            toastMsg.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    }
});