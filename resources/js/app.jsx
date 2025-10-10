import React from "react";
import { createRoot } from "react-dom/client";
import Dashboard from "./components/Dashboard/Dashboard.jsx";
import LaptopTable from "./components/LaptopTable.jsx";
import Sidebar from "./components/Sidebar.jsx";
import PeminjamTable from "./components/PeminjamTable.jsx";
import Laporan from './components/Laporan.jsx';
import ArchiveLaptopTable from "./components/ArchiveLaptopTable.jsx";
import '../assets/vendor/scss/theme-default.scss';
import '../assets/vendor/libs/apex-charts/apex-charts.scss';
import '../assets/vendor/libs/apex-charts/apexcharts.js';


// ===== Dashboard =====
const dashboardEl = document.getElementById("react-dashboard");
if (dashboardEl) {
  const data = window.dashboardData || {};
  createRoot(dashboardEl).render(
    <Dashboard
      user={data.user || null}
      totalLaptop={data.totalLaptop || 0}
      tersedia={data.tersedia || 0}
      diarsip={data.diarsip || 0}
      isGuest={data.isGuest}
      laptopStats={data.laptopStats || []}
    />
  );
}

// ===== Laptop Table =====
const laptopEl = document.getElementById("laptop-table");
if (laptopEl) {
  createRoot(laptopEl).render(<LaptopTable />);
}

// ===== Peminjam Table =====
const peminjamEl = document.getElementById("react-peminjam-table");
if (peminjamEl) {
  createRoot(peminjamEl).render(<PeminjamTable />);
}

// ===== Archive Laptop Table =====
const archiveEl = document.getElementById("archive-laptop-table");
if (archiveEl) {
  createRoot(archiveEl).render(<ArchiveLaptopTable />);
}

// ===== Sidebar =====
const sidebarEl = document.getElementById("sidebar");
if (sidebarEl) {
  createRoot(sidebarEl).render(<Sidebar />);
}

// ===== Laporan =====
const appEl = document.getElementById("app");
if (appEl) {
  createRoot(appEl).render(<Laporan />);
}
