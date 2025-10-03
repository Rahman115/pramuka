// Konfirmasi penghapusan
function deleteAnggota(id) {
    if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
        // Implementasi AJAX untuk penghapusan
        fetch(`api/anggota_delete.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Anggota berhasil dihapus');
                location.reload();
            } else {
                alert('Gagal menghapus anggota');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus anggota');
        });
    }
}

// Validasi form
function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.style.borderColor = 'var(--danger)';
        } else {
            field.style.borderColor = '';
        }
    });

    return isValid;
}

// Format tanggal
function formatDate(dateString) {
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Search functionality
function searchTable(tableId, searchId) {
    const search = document.getElementById(searchId).value.toLowerCase();
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent.toLowerCase();
            if (cellText.includes(search)) {
                found = true;
                break;
            }
        }

        rows[i].style.display = found ? '' : 'none';
    }
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });

    // Add loading state to buttons
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            }
        });
    });
});

// Export data
function exportToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    const rows = table.querySelectorAll('tr');
    let csv = [];

    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Remove action buttons from export
            if (!cols[j].classList.contains('actions')) {
                row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
            }
        }
        
        csv.push(row.join(','));
    }

    // Download CSV file
    const csvString = csv.join('\n');
    const blob = new Blob([csvString], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', filename + '.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}


// Fungsi delete untuk semua entitas
function deleteAnggota(id) {
    if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
        window.location.href = 'index.php?action=delete&page=anggota&id=' + id;
    }
}

function deleteGudep(id) {
    if (confirm('Apakah Anda yakin ingin menghapus gudep ini?')) {
        window.location.href = 'index.php?action=delete&page=gudep&id=' + id;
    }
}

function deleteKwarcab(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pengurus ini?')) {
        window.location.href = 'index.php?action=delete&page=kwarcab&id=' + id;
    }
}

function deleteDkc(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data anggota DKC ini?')) {
        window.location.href = 'index.php?action=delete&page=dkc&id=' + id;
    }
}

function deletePendamping(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pendamping ini?')) {
        window.location.href = 'index.php?action=delete&page=pendamping&id=' + id;
    }
}

function deletePeserta(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data peserta didik ini?')) {
        window.location.href = 'index.php?action=delete&page=peserta&id=' + id;
    }
}