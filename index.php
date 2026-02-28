<?php
// index.php – halaman utama Task Manager
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>TickTick Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .card {
      opacity: 0;
      transform: translateY(10px);
      animation: fadeInUp 0.5s ease forwards;
    }
    @keyframes fadeInUp {
      to { opacity: 1; transform: translateY(0); }
    }
    .card:hover {
      transform: scale(1.02);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
      transition: all 0.3s ease;
    }
    .btn:hover {
      transform: translateY(-2px);
      transition: all 0.2s ease;
    }
  </style>
</head>
<body class="bg-light">

<!-- 🔹 Navbar dengan navigasi -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">TickTick</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<div class="container mt-4">

  <!-- Form Tambah Task di ATAS -->
  <div class="card mb-4 shadow-sm rounded">
    <div class="card-body">
      <h5 class="card-title">Tambah Task Baru</h5>
      <form id="add-task-form">
        <div class="mb-2">
          <input type="text" id="title" class="form-control" placeholder="Judul Task" required>
        </div>
        <div class="mb-2">
          <input type="text" id="description" class="form-control" placeholder="Deskripsi Task" required>
        </div>
        <div class="mb-2">
          <select id="status" class="form-select">
            <option value="Pending">Pending</option>
            <option value="Selesai">Selesai</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-plus-circle"></i> Tambah Task
        </button>
      </form>
    </div>
  </div>

  <!-- Toolbar filter + search + export Excel -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <button class="btn btn-outline-secondary btn-sm me-1" onclick="filterTasks('all')">
        <i class="bi bi-list-task"></i> Semua
      </button>
      <button class="btn btn-outline-warning btn-sm me-1" onclick="filterTasks('Pending')">
        <i class="bi bi-hourglass-split"></i> Pending
      </button>
      <button class="btn btn-outline-success btn-sm me-1" onclick="filterTasks('Selesai')">
        <i class="bi bi-check-circle"></i> Selesai
      </button>
      <button class="btn btn-outline-success btn-sm" onclick="exportExcel()">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
      </button>
    </div>
    <div class="d-flex w-50">
      <div class="input-group me-2">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="search-bar" class="form-control" placeholder="Cari task...">
      </div>
      <select id="sort-select" class="form-select w-auto">
        <option value="default">Urutkan</option>
        <option value="status">Status</option>
        <option value="date">Tanggal</option>
      </select>
    </div>
  </div>

  <!-- Daftar Task -->
  <div id="task-list"></div>

  <!-- Pagination -->
  <nav aria-label="Task pagination" class="mt-3">
    <ul class="pagination justify-content-center" id="pagination"></ul>
  </nav>
</div>

<!-- Toast Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="toast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toast-body">Notifikasi</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script src="assets/js/tasks.js"></script>
</body>
</html>