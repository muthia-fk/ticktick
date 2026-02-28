const API_URL = "http://localhost/ticktick/api";

let allTasks = [];
let currentPage = 1;
const tasksPerPage = 5; // jumlah task per halaman

// 🔹 Read semua task
async function getTasks() {
    const response = await fetch(`${API_URL}/read.php`);
    allTasks = await response.json();
    renderTasks(allTasks, currentPage);
}

function renderTasks(tasks, page = 1) {
    const list = document.getElementById("task-list");
    list.innerHTML = "";

    let pendingCount = 0;
    let doneCount = 0;

    // Pagination logic
    const start = (page - 1) * tasksPerPage;
    const end = start + tasksPerPage;
    const paginatedTasks = tasks.slice(start, end);

    paginatedTasks.forEach(task => {
        if (task.status === "Pending") pendingCount++;
        if (task.status === "Selesai") doneCount++;

        const card = document.createElement("div");
        card.className = "card mb-2 shadow-sm rounded";

        const badgeClass = task.status === "Selesai" ? "badge bg-success" : "badge bg-warning text-dark";

        card.innerHTML = `
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1">${task.title}</h5>
                    <p class="card-text small text-muted">${task.description}</p>
                    <span class="${badgeClass}">${task.status}</span>
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

    document.getElementById("pending-count").textContent = `Pending: ${pendingCount}`;
    document.getElementById("done-count").textContent = `Selesai: ${doneCount}`;

    renderPagination(tasks.length, page);
}

// 🔹 Render tombol pagination
function renderPagination(totalTasks, page) {
    const totalPages = Math.ceil(totalTasks / tasksPerPage);
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    // Prev button
    const prev = document.createElement("li");
    prev.className = `page-item ${page === 1 ? "disabled" : ""}`;
    prev.innerHTML = `<a class="page-link" href="#">Prev</a>`;
    prev.onclick = () => {
        if (page > 1) {
            currentPage--;
            renderTasks(allTasks, currentPage);
        }
    };
    pagination.appendChild(prev);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.className = `page-item ${i === page ? "active" : ""}`;
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.onclick = () => {
            currentPage = i;
            renderTasks(allTasks, currentPage);
        };
        pagination.appendChild(li);
    }

    // Next button
    const next = document.createElement("li");
    next.className = `page-item ${page === totalPages ? "disabled" : ""}`;
    next.innerHTML = `<a class="page-link" href="#">Next</a>`;
    next.onclick = () => {
        if (page < totalPages) {
            currentPage++;
            renderTasks(allTasks, currentPage);
        }
    };
    pagination.appendChild(next);
}

// 🔹 Create task baru
async function createTask(title, description, status) {
    const response = await fetch(`${API_URL}/create.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title, description, status })
    });
    const result = await response.json();
    showToast(result.message, "success");
    getTasks();
}

// 🔹 Update task
async function updateTask(id) {
    const response = await fetch(`${API_URL}/update.php`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id: id,
            title: "Update Judul",
            description: "Update Deskripsi",
            status: "Selesai"
        })
    });
    const result = await response.json();
    showToast(result.message, "info");
    getTasks();
}

// 🔹 Delete task
async function deleteTask(id) {
    const response = await fetch(`${API_URL}/delete.php`, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });
    const result = await response.json();
    showToast(result.message, "danger");
    getTasks();
}

// 🔹 Filter task berdasarkan status
function filterTasks(status) {
    if (status === "all") {
        renderTasks(allTasks, currentPage);
    } else {
        const filtered = allTasks.filter(task => task.status === status);
        currentPage = 1; // reset ke halaman pertama
        renderTasks(filtered, currentPage);
    }
}

// 🔹 Sorting task
function sortTasks(criteria) {
    let sorted = [...allTasks]; // copy array

    if (criteria === "status") {
        sorted.sort((a, b) => a.status.localeCompare(b.status));
    } else if (criteria === "date") {
        sorted.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    }

    currentPage = 1;
    renderTasks(sorted, currentPage);
}

// 🔹 Export task ke Excel (XLSX)
function exportExcel() {
    if (allTasks.length === 0) {
        showToast("Tidak ada task untuk diexport.", "warning");
        return;
    }

    const worksheet = XLSX.utils.json_to_sheet(allTasks);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Tasks");
    XLSX.writeFile(workbook, "tasks_export.xlsx");

    showToast("Tasks berhasil diexport ke Excel.", "success");
}

// 🔹 Toast notification
function showToast(message, type = "primary") {
    const toastEl = document.getElementById("toast");
    const toastBody = document.getElementById("toast-body");

    toastEl.className = `toast align-items-center text-bg-${type} border-0`;
    toastBody.textContent = message;

    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
}

// 🔹 Event listener
document.addEventListener("DOMContentLoaded", () => {
    getTasks();

    document.getElementById("add-task-form").addEventListener("submit", e => {
        e.preventDefault();
        const title = document.getElementById("title").value;
        const description = document.getElementById("description").value;
        const status = document.getElementById("status").value;
        createTask(title, description, status);
    });

    document.getElementById("search-bar").addEventListener("input", e => {
        const keyword = e.target.value.toLowerCase();
        const filtered = allTasks.filter(task =>
            task.title.toLowerCase().includes(keyword) ||
            task.description.toLowerCase().includes(keyword)
        );
        currentPage = 1;
        renderTasks(filtered, currentPage);
    });

    document.getElementById("sort-select").addEventListener("change", e => {
        const criteria = e.target.value;
        if (criteria === "default") {
            renderTasks(allTasks, currentPage);
        } else {
            sortTasks(criteria);
        }
    });
});