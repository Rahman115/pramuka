// Mobile Menu Functionality dengan debug
document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM loaded - initializing mobile menu');
  
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const navbar = document.getElementById('navbar');

  console.log('Mobile menu toggle:', mobileMenuToggle);
  console.log('Navbar:', navbar);

  if (mobileMenuToggle && navbar) {
    console.log('Both elements found, adding event listeners');
    
    mobileMenuToggle.addEventListener('click', function (event) {
      event.stopPropagation();
      console.log('Mobile menu toggle clicked');
      
      navbar.classList.toggle('active');
      mobileMenuToggle.classList.toggle('active');

      // Change icon
      const icon = mobileMenuToggle.querySelector('i');
      if (navbar.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
        console.log('Menu opened');
      } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
        console.log('Menu closed');
      }
    });

    // Close menu when clicking on a link (mobile)
    const navLinks = document.querySelectorAll('.nav-link');
    console.log('Nav links found:', navLinks.length);
    
    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        if (window.innerWidth <= 768) {
          navbar.classList.remove('active');
          mobileMenuToggle.classList.remove('active');

          const icon = mobileMenuToggle.querySelector('i');
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
          console.log('Menu closed via link click');
        }
      });
    });

    // Close menu when clicking outside (mobile)
    document.addEventListener('click', function (event) {
      if (
        window.innerWidth <= 768 &&
        navbar.classList.contains('active') &&
        !navbar.contains(event.target) &&
        !mobileMenuToggle.contains(event.target)
      ) {
        navbar.classList.remove('active');
        mobileMenuToggle.classList.remove('active');

        const icon = mobileMenuToggle.querySelector('i');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
        console.log('Menu closed via outside click');
      }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
      console.log('Window resized to:', window.innerWidth);
      if (window.innerWidth > 768) {
        navbar.classList.remove('active');
        mobileMenuToggle.classList.remove('active');

        const icon = mobileMenuToggle.querySelector('i');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
    });
  } else {
    console.error('Required elements not found:');
    console.error('mobileMenuToggle:', mobileMenuToggle);
    console.error('navbar:', navbar);
  }

  // ... rest of your code

  // Add active state based on current page
  function setActiveNav() {
    const currentPage = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link')

    navLinks.forEach(link => {
      const linkPath = new URL(link.href).pathname;
      if (linkPath === currentPage) {
        link.classList.add('active')
      } else {
        link.classList.remove('active')
      }
    })
  }

  setActiveNav()
})

// Konfirmasi penghapusan
function confirmDelete(entity, id) {
  const entities = {
    'anggota': 'anggota ini',
    'gudep': 'gudep ini',
    'kwarcab': 'data pengurus ini',
    'dkc': 'data anggota DKC ini',
    'pendamping': 'data pendamping ini',
    'peserta': 'data peserta didik ini'
  };

  const message = entities[entity] || 'data ini';
  
  if (confirm(`Apakah Anda yakin ingin menghapus ${message}?`)) {
    window.location.href = `index.php?action=delete&page=${entity}&id=${id}`;
  }
}

// Validasi form
function validateForm(form) {
  const requiredFields = form.querySelectorAll('[required]')
  let isValid = true

  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      isValid = false
      field.style.borderColor = 'var(--danger)'
      
      // Tambahkan pesan error
      let errorMsg = field.parentNode.querySelector('.error-message')
      if (!errorMsg) {
        errorMsg = document.createElement('div')
        errorMsg.className = 'error-message'
        errorMsg.style.color = 'var(--danger)'
        errorMsg.style.fontSize = '0.8rem'
        errorMsg.style.marginTop = '0.25rem'
        field.parentNode.appendChild(errorMsg)
      }
      errorMsg.textContent = 'Field ini wajib diisi'
    } else {
      field.style.borderColor = ''
      const errorMsg = field.parentNode.querySelector('.error-message')
      if (errorMsg) {
        errorMsg.remove()
      }
    }
  })

  return isValid
}

// Format tanggal
function formatDate(dateString) {
  if (!dateString) return '-';
  
  try {
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '-';
    
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' }
    return date.toLocaleDateString('id-ID', options)
  } catch (error) {
    console.error('Error formatting date:', error);
    return '-';
  }
}

// Search functionality
function searchTable(tableId, searchId) {
  const search = document.getElementById(searchId).value.toLowerCase()
  const table = document.getElementById(tableId)
  
  if (!table) {
    console.error(`Table with id ${tableId} not found`);
    return;
  }
  
  const rows = table.getElementsByTagName('tr')

  for (let i = 1; i < rows.length; i++) {
    const cells = rows[i].getElementsByTagName('td')
    let found = false

    for (let j = 0; j < cells.length; j++) {
      // Skip action columns
      if (cells[j].classList.contains('actions')) continue;
      
      const cellText = cells[j].textContent.toLowerCase()
      if (cellText.includes(search)) {
        found = true
        break
      }
    }

    rows[i].style.display = found ? '' : 'none'
  }
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function () {
  // Auto-hide alerts after 5 seconds
  const alerts = document.querySelectorAll('.alert')
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.opacity = '0';
      alert.style.transition = 'opacity 0.5s ease';
      setTimeout(() => {
        alert.style.display = 'none';
      }, 500);
    }, 5000);
  });

  // Add loading state to buttons
  const forms = document.querySelectorAll('form')
  forms.forEach(form => {
    form.addEventListener('submit', function () {
      const submitBtn = this.querySelector('button[type="submit"]')
      if (submitBtn) {
        submitBtn.disabled = true
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...'
        
        // Re-enable button after 10 seconds (fallback)
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Submit';
        }, 10000);
      }
    });
  });

  // Store original button text
  const submitButtons = document.querySelectorAll('button[type="submit"]');
  submitButtons.forEach(btn => {
    btn.setAttribute('data-original-text', btn.innerHTML);
  });
});

// Export data
function exportToCSV(tableId, filename) {
  const table = document.getElementById(tableId);
  
  if (!table) {
    console.error(`Table with id ${tableId} not found`);
    return;
  }
  
  const rows = table.querySelectorAll('tr');
  let csv = [];

  for (let i = 0; i < rows.length; i++) {
    const row = [];
    const cols = rows[i].querySelectorAll('td, th');

    for (let j = 0; j < cols.length; j++) {
      // Remove action buttons and hidden columns from export
      if (!cols[j].classList.contains('actions') && 
          !cols[j].classList.contains('no-export') &&
          cols[j].style.display !== 'none') {
        const text = cols[j].innerText.replace(/"/g, '""').trim();
        row.push('"' + text + '"');
      }
    }

    if (row.length > 0) {
      csv.push(row.join(','));
    }
  }

  // Download CSV file
  try {
    const csvString = csv.join('\n');
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    a.download = (filename || 'export') + '.csv';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  } catch (error) {
    console.error('Error exporting CSV:', error);
    alert('Terjadi kesalahan saat mengekspor data');
  }
}

// Enhanced delete functions with better error handling
function deleteAnggota(id) {
  confirmDelete('anggota', id);
}

function deleteGudep(id) {
  confirmDelete('gudep', id);
}

function deleteKwarcab(id) {
  confirmDelete('kwarcab', id);
}

function deleteDkc(id) {
  confirmDelete('dkc', id);
}

function deletePendamping(id) {
  confirmDelete('pendamping', id);
}

function deletePeserta(id) {
  confirmDelete('peserta', id);
}

// Utility function to toggle password visibility
function togglePasswordVisibility(inputId) {
  const input = document.getElementById(inputId);
  const icon = document.querySelector(`[onclick="togglePasswordVisibility('${inputId}')"] i`);
  
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}