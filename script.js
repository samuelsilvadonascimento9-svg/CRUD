document.addEventListener("DOMContentLoaded", () => {
    // MODAL NEO-BRUTALIST
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