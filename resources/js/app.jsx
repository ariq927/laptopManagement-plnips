import React from "react";
import { createRoot } from "react-dom/client";
import Dashboard from "./components/Dashboard/Dashboard.jsx";
import LaptopTable from "./components/LaptopTable.jsx"; // ✅ import komponen tabel


// Mount Dashboard (kalau ada)
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

// ✅ Mount LaptopTable (kalau ada)
const laptopEl = document.getElementById("laptop-table");

if (laptopEl) {
  createRoot(laptopEl).render(<LaptopTable />);
}
