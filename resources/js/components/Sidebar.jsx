import React from "react";
import { Home, Monitor, Users, HelpCircle, FileText } from "lucide-react";

const Sidebar = () => {
  const activeMenu = document.body.getAttribute("data-active-menu") || "";

  const menus = [
    { name: "Dashboard", icon: <Home size={18} />, url: "dashboard" },
    { header: "DAFTAR LAPTOP & PEMINJAM" },
    { name: "Daftar Laptop", icon: <Monitor size={18} />, url: "tables/laptop" },
    { name: "Daftar Peminjam", icon: <Users size={18} />, url: "tables/peminjam" },
    { header: "MISC" },
    { name: "Support", icon: <HelpCircle size={18} />, url: "support" },
    { name: "Documentation", icon: <FileText size={18} />, url: "docs" },
  ];

  return (
    <aside className="h-screen bg-[#005bac] text-gray-200 flex flex-col">
      {/* Logo */}
      <div className="p-4 flex items-center gap-2">
        <img src="/assets/img/white-pln2.png" alt="PLN Logo" className="h-8" />
        <span className="font-bold text-white">Laptop Management</span>
      </div>

      {/* Menu */}
      <nav className="flex-1 px-2 py-4">
        {menus.map((menu, idx) =>
          menu.header ? (
            <div key={idx} className="mt-4 mb-2 px-2 text-xs font-semibold uppercase text-gray-400">
              {menu.header}
            </div>
          ) : (
            <a
              key={idx}
              href={`/${menu.url}`}
              className={`flex items-center gap-2 px-3 py-2 rounded-lg mb-1 transition-colors 
                ${activeMenu.startsWith(menu.url) ? "bg-white text-[#005bac] font-semibold" : "hover:bg-[#1d6dd8]"}
              `}
            >
              {menu.icon}
              <span>{menu.name}</span>
            </a>
          )
        )}
      </nav>
    </aside>
  );
};

export default Sidebar;
