import React from "react";
import { createRoot } from "react-dom/client";
import Dashboard from "./components/Dashboard/Dashboard.jsx";
import LaptopTable from "./components/LaptopTable.jsx";
import Sidebar from "./components/Sidebar.jsx"; 
import PeminjamTable from "./components/PeminjamTable.jsx";
import Laporan from './components/Laporan.jsx';

if (!window.dashboardRoot) window.dashboardRoot = null;
if (!window.laptopRoot) window.laptopRoot = null;
if (!window.sidebarRoot) window.sidebarRoot = null;

const dashboardEl = document.getElementById("react-dashboard");
if (dashboardEl) {
  const data = window.dashboardData || {};
  if (!window.dashboardRoot) {
    window.dashboardRoot = createRoot(dashboardEl);
  }
  window.dashboardRoot.render(
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

const peminjamEl = document.getElementById("react-peminjam-table");
if (peminjamEl) {
  createRoot(peminjamEl).render(<PeminjamTable />);
}

const laptopEl = document.getElementById("laptop-table");
if (laptopEl) {
  if (!window.laptopRoot) {
    window.laptopRoot = createRoot(laptopEl);
  }
  window.laptopRoot.render(<LaptopTable />);
}

const sidebarEl = document.getElementById("sidebar");
if (sidebarEl) {
  if (!window.sidebarRoot) {
    window.sidebarRoot = createRoot(sidebarEl);
  }
  window.sidebarRoot.render(<Sidebar />);
}

const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(<Laporan />)