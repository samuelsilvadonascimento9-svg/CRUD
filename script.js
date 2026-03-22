document.addEventListener("DOMContentLoaded", () => {
    
    // 1. CURSOR DE PRECISÃO (Sem lag)
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');

    if (cursorDot && cursorOutline) {
        window.addEventListener('mousemove', (e) => {
            const posX = e.clientX;
            const posY = e.clientY;

            // Ponto central
            cursorDot.style.left = `${posX}px`;
            cursorDot.style.top = `${posY}px`;

            // Contorno com CSS transition (smooth)
            cursorOutline.style.left = `${posX}px`;
            cursorOutline.style.top = `${posY}px`;
        });
    }

    // 2. MICRO-MAGNETISMO NOS BOTÕES
    const magnets = document.querySelectorAll('.hover-magnetic');
    
    magnets.forEach(magnet => {
        magnet.addEventListener('mousemove', (e) => {
            const position = magnet.getBoundingClientRect();
            const x = e.clientX - position.left - position.width / 2;
            const y = e.clientY - position.top - position.height / 2;
            // Move bem sutilmente, sem atrapalhar o clique
            magnet.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
        });
        
        magnet.addEventListener('mouseout', () => {
            magnet.style.transform = 'translate(0px, 0px)';
        });
    });

    // 3. MODAL AURA (O Aviso de Sistema)
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