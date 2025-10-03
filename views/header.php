<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Keanggotaan Pramuka</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <i class="fas fa-campground"></i>
                <h1>Sistem Pramuka</h1>
            </div>
            <nav class="navbar">
                <ul>
                    <li><a href="index.php?action=dashboard" class="<?php echo ($action == 'dashboard') ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="index.php?action=list&page=anggota" class="<?php echo ($page == 'anggota') ? 'active' : ''; ?>"><i class="fas fa-users"></i> Anggota</a></li>
                    <li><a href="index.php?action=list&page=gudep" class="<?php echo ($page == 'gudep') ? 'active' : ''; ?>"><i class="fas fa-flag"></i> Gudep</a></li>
                    <li><a href="index.php?action=list&page=kwarcab" class="<?php echo ($page == 'kwarcab') ? 'active' : ''; ?>"><i class="fas fa-user-tie"></i> Kwarcab</a></li>
                    <li><a href="index.php?action=list&page=dkc" class="<?php echo ($page == 'dkc') ? 'active' : ''; ?>"><i class="fas fa-users-cog"></i> DKC</a></li>
                    <li><a href="index.php?action=list&page=pendamping" class="<?php echo ($page == 'pendamping') ? 'active' : ''; ?>"><i class="fas fa-chalkboard-teacher"></i> Pendamping</a></li>
                    <li><a href="index.php?action=list&page=peserta" class="<?php echo ($page == 'peserta') ? 'active' : ''; ?>"><i class="fas fa-user-graduate"></i> Peserta Didik</a></li>
                </ul>
            </nav>
        </header>
        <main class="main-content">