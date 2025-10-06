import { useState } from "react";

export default function Laporan() {
  const [filters, setFilters] = useState({
    departemen: "",
    status: "",
    from: "",
    to: "",
    format: "excel"
  });

  const handleExport = () => {
    const query = new URLSearchParams(filters).toString();
    window.open(`/laporan/export?${query}`);
  };

  return (
    <div className="p-4 max-w-xl mx-auto">
      <h2 className="text-xl font-bold mb-4">Laporan Peminjaman Laptop</h2>

      <div className="mb-2">
        <input
          type="text"
          placeholder="Departemen"
          className="border p-2 w-full"
          value={filters.departemen}
          onChange={e => setFilters({...filters, departemen: e.target.value})}
        />
      </div>

      <div className="mb-2">
        <input
          type="text"
          placeholder="Status"
          className="border p-2 w-full"
          value={filters.status}
          onChange={e => setFilters({...filters, status: e.target.value})}
        />
      </div>

      <div className="mb-2 flex gap-2">
        <input
          type="date"
          className="border p-2 w-1/2"
          value={filters.from}
          onChange={e => setFilters({...filters, from: e.target.value})}
        />
        <input
          type="date"
          className="border p-2 w-1/2"
          value={filters.to}
          onChange={e => setFilters({...filters, to: e.target.value})}
        />
      </div>

      <div className="mb-4">
        <select
          className="border p-2 w-full"
          value={filters.format}
          onChange={e => setFilters({...filters, format: e.target.value})}
        >
          <option value="excel">Excel</option>
          <option value="pdf">PDF</option>
        </select>
      </div>

      <button
        onClick={handleExport}
        className="bg-blue-500 text-white px-4 py-2 rounded"
      >
        Generate Laporan
      </button>
    </div>
  );
}
