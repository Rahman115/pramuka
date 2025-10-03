<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Keanggotaan Pramuka</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
     <script src="https://cdn.jsdelivr.net/npm/eruda"></script>
    <script>
      // Inisialisasi Eruda
      eruda.init()
      console.log('Eruda initialized')
    </script>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-top">
                <div class="logo">
                    <i class="fas fa-campground"></i>
                    <h1>Sistem Pramuka</h1>
                </div>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="navbar" id="navbar">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="index.php?action=dashboard" class="nav-link <?php echo ($action == 'dashboard') ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list&page=anggota" class="nav-link <?php echo ($page == 'anggota') ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i>
                            <span>Anggota</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list&page=gudep" class="nav-link <?php echo ($page == 'gudep') ? 'active' : ''; ?>">
                            <i class="fas fa-flag"></i>
                            <span>Gudep</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list&page=kwarcab" class="nav-link <?php echo ($page == 'kwarcab') ? 'active' : ''; ?>">
                            <i class="fas fa-user-tie"></i>
                            <span>Kwarcab</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list&page=dkc" class="nav-link <?php echo ($page == 'dkc') ? 'active' : ''; ?>">
                            <i class="fas fa-users-cog"></i>
                            <span>DKC</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list&page=pendamping" class="nav-link <?php echo ($page == 'pendamping') ? 'active' : ''; ?>">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Pendamping</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list&page=peserta" class="nav-link <?php echo ($page == 'peserta') ? 'active' : ''; ?>">
                            <i class="fas fa-user-graduate"></i>
                            <span>Peserta Didik</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
        <main class="main-content">