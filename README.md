## 📂 README.md

```markdown
# TickTick Task Manager

A modern CRUD web application built with **PHP, Bootstrap 5, and JavaScript**.  
This project is designed as a practicum system for managing tasks with a lively, intuitive UI.

---

## ✨ Features
- ✅ Create, Read, Update, Delete (CRUD) tasks
- ✅ Status management: **Pending** & **Selesai**
- ✅ Separate pages for Pending (`pending.php`) and Selesai (`selesai.php`)
- ✅ Bootstrap 5 UI with icons, badges, hover effects, shadows, rounded corners
- ✅ Search bar, sorting, and pagination
- ✅ Toast notifications for feedback (instead of alert)
- ✅ Export tasks to **Excel** (via SheetJS)
- ✅ Consistent navigation across all pages

---

## 📂 Project Structure
```
ticktick/
├── api/                # PHP API endpoints (create, read, update, delete)
├── assets/
│   └── js/tasks.js     # Main JavaScript logic
├── index.php           # Main dashboard (all tasks)
├── pending.php         # Page for Pending tasks
├── selesai.php         # Page for Selesai tasks
└── README.md           # Project documentation
```

---

## 🚀 Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/muthia-fk/ticktick.git
   ```
2. Move project to your local server directory (e.g., `C:\xampp\htdocs\ticktick`).
3. Import database schema (if provided).
4. Start Apache & MySQL in XAMPP.
5. Open in browser:
   ```
   http://localhost/ticktick/index.php
   ```

---

## 📊 Usage
- Tambah task melalui form di atas dashboard.
- Gunakan navbar untuk navigasi ke **Semua / Pending / Selesai**.
- Filter, search, dan sort task sesuai kebutuhan.
- Klik **Export Excel** untuk mengunduh semua task dalam format `.xlsx`.

---

## 🛠️ Tech Stack
- **PHP** (API backend)
- **Bootstrap 5** (UI framework)
- **JavaScript (ES6)** (frontend logic)
- **SheetJS (xlsx.js)** (Excel export)
- **MySQL** (database)

---

## 📸 Screenshots
(Add screenshots of index.php, pending.php, selesai.php here)

---

## 👩‍💻 Author
Developed by **Muthia FK**  
Practicum project – CRUD Task Manager with modern UI/UX
```