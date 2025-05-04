document.addEventListener('DOMContentLoaded', function() {
    // Get all radio buttons
    const radioButtons = document.querySelectorAll('input[type="radio"][name="status"]');
    
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const form = this.closest('form');
            const alasanContainer = form.querySelector('.rejection-reason');
            const alasanTextarea = form.querySelector('textarea[name="alasan_penolakan"]');
            
            console.log('Radio changed:', this.value);
            console.log('Container found:', alasanContainer);
            
            if (this.value === 'rejected') {
                // Show rejection reason field and make it required
                if (alasanContainer) {
                    alasanContainer.style.display = 'block';
                    alasanTextarea.required = true;
                    alasanTextarea.value = ''; // Clear any existing value
                }
            } else {
                // Hide rejection reason field and set value to "-"
                if (alasanContainer) {
                    alasanContainer.style.display = 'none';
                    alasanTextarea.required = false;
                    alasanTextarea.value = '-';
                }
            }
        });
    });

    // Handle form submission
    const forms = document.querySelectorAll('form[action*="verifikasi"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const selectedStatus = form.querySelector('input[name="status"]:checked').value;
            const alasanTextarea = form.querySelector('textarea[name="alasan_penolakan"]');
            
            if (selectedStatus === 'approved') {
                // Jika status disetujui, otomatis isi alasan penolakan dengan "-"
                alasanTextarea.value = '-';
            }
        });
    });
}); 