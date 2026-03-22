document.addEventListener("DOMContentLoaded", () => {
    
    // 1. CURSOR CUSTOMIZADO (Rápido e Fluido)
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');

    if (cursorDot && cursorOutline) {
        window.addEventListener('mousemove', (e) => {
            const posX = e.clientX;
            const posY = e.clientY;

            // O Ponto segue instantaneamente
            cursorDot.style.left = `${posX}px`;
            cursorDot.style.top = `${posY}px`;

            // O Contorno segue o atraso que foi setado no CSS (0.1s ease-out)
            cursorOutline.style.left = `${posX}px`;
            cursorOutline.style.top = `${posY}px`;
        });
    }

    // 2. EFEITO MAGNÉTICO LEVE NOS BOTÕES (Bom para a usabilidade)
    const magnets = document.querySelectorAll('.hover-magnetic');
    
    magnets.forEach(magnet => {
        magnet.addEventListener('mousemove', (e) => {
            const position = magnet.getBoundingClientRect();
            const x = e.clientX - position.left - position.width / 2;
            const y = e.clientY - position.top - position.height / 2;
            
            magnet.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px)`;
        });
        
        magnet.addEventListener('mouseout', () => {
            magnet.style.transform = 'translate(0px, 0px)';
        });
    });

    // 3. JANELA DE AVISO DE EXCLUSÃO (O MODAL)
    const deleteButtons = document.querySelectorAll('.custom-delete-btn');
    const modalOverlay = document.getElementById('deleteModal');
    const btnCancel = document.getElementById('btnCancelDelete');
    const btnConfirm = document.getElementById('btnConfirmDelete');
    let deleteUrl = ''; // Guarda o link original do PHP

    if (modalOverlay) {
        // Ao clicar em uma lixeira...
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); // Trava a ação original
                deleteUrl = this.getAttribute('href'); // Salva o endereço de exclusão ("delete.php?id=...")
                modalOverlay.classList.add('active'); // Abre a nossa janela bonita
            });
        });

        // Clicou em "ABORTAR"
        btnCancel.addEventListener('click', () => {
            modalOverlay.classList.remove('active'); 
        });

        // Clicou em "CONFIRMAR PURGO"
        btnConfirm.addEventListener('click', () => {
            window.location.href = deleteUrl; // Envia o comando pro backend em PHP
        });
    }
});