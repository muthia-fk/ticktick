<?php
// pending.php – halaman khusus task Pending
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Task Pending - TickTick</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- 🔹 Navbar dengan navigasi -->
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-dark" href="index.php">TickTick</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="bi bi-house"></i> Semua</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="pending.php"><i class="bi bi-hourglass-split"></i> Pending</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="selesai.php"><i class="bi bi-check-circle"></i> Selesai</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="text-warning">Daftar Task Pending</h3>
  <div id="task-list"></div>
</div>

<script>
const API_URL = "http://localhost/ticktick/api";

async function getPendingTasks() {
    const response = await fetch(`${API_URL}/read.php`);
    const tasks = await response.json();

    const list = document.getElementById("task-list");
    list.innerHTML = "";

    tasks.filter(task => task.status === "Pending").forEach(task => {
        const card = document.createElement("div");
        card.className = "card mb-2 shadow-sm rounded";
        card.innerHTML = `
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1">${task.title}</h5>
                    <p class="card-text small text-muted">${task.description}</p>
                    <span class="badge bg-warning text-dark">${task.status}</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary me-1" onclick="updateTask(${task.id})">
                        <i class="bi bi-pencil"></i> Update
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        `;
        list.appendChild(card);
    });
}

async function updateTask(id) {
    const response = await fetch(`${API_URL}/update.php`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, title: "Update Judul", description: "Update Deskripsi", status: "Selesai" })
    });
    const result = await response.json();
    alert(result.message);
    getPendingTasks();
}

async function deleteTask(id) {
    const response = await fetch(`${API_URL}/delete.php`, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });
    const result = await response.json();
    alert(result.message);
    getPendingTasks();
}

document.addEventListener("DOMContentLoaded", getPendingTasks);
</script>
</body>
</html>