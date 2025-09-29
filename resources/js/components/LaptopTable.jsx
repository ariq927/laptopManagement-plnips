import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client"; // React 18/19
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function LaptopTable() {
  const [laptops, setLaptops] = useState([]);
  const [pagination, setPagination] = useState({});
  const [search, setSearch] = useState("");
  const [perPage, setPerPage] = useState(10);

  const fetchData = async (page = 1) => {
    const res = await fetch(`/api/laptop?search=${search}&page=${page}&per_page=${perPage}`);
    const json = await res.json();
    setLaptops(json.data);
    setPagination(json);
  };

  useEffect(() => {
    fetchData();
  }, [search, perPage]);

  const handleArchive = async (id) => {
    try {
      const res = await fetch(`/api/laptop/${id}/archive`, { method: "PATCH" });
      if (!res.ok) throw new Error("Gagal mengarsipkan laptop");
      toast.success("Laptop berhasil diarsip"); // <-- Toast di sini
      fetchData(pagination.current_page);
    } catch (err) {
      toast.error(err.message);
    }
  };

  const handleRestore = async (id) => {
    try {
      const res = await fetch(`/api/laptop/${id}/restore`, { method: "PATCH" });
      if (!res.ok) throw new Error("Gagal mengembalikan laptop");
      toast.success("Laptop berhasil dikembalikan"); // <-- Toast di sini
      fetchData(pagination.current_page);
    } catch (err) {
      toast.error(err.message);
    }
  };

  return (
    <div className="card">
      <div className="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Laptop</h5>
        <div className="d-flex gap-2">
          <select className="form-select" style={{ width: "auto" }} value={perPage} onChange={(e) => setPerPage(Number(e.target.value))}>
            <option value="10">10 / halaman</option>
            <option value="20">20 / halaman</option>
            <option value="50">50 / halaman</option>
            <option value="100">100 / halaman</option>
          </select>

          <input type="text" className="form-control" placeholder="Cari laptop..." value={search} onChange={(e) => setSearch(e.target.value)} />

          <a href="/laptop/create" className="btn btn-primary">+ Tambah Laptop</a>
        </div>
      </div>

      <div className="table-responsive">
        <table className="table table-bordered">
          <thead className="table-dark">
            <tr>
              <th>No</th>
              <th>Merek</th>
              <th>Tipe</th>
              <th>Spesifikasi</th>
              <th>Nomor Seri</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {laptops.length === 0 ? (
              <tr>
                <td colSpan="7" className="text-center">Belum ada data laptop</td>
              </tr>
            ) : (
              laptops.map((laptop, index) => (
                <tr key={laptop.id}>
                  <td>{(pagination.from || 0) + index}</td>
                  <td>{laptop.merek}</td>
                  <td>{laptop.tipe}</td>
                  <td>{laptop.spesifikasi}</td>
                  <td>{laptop.serial_number}</td>
                  <td className="d-flex gap-1">
  {laptop.status === "tersedia" && (
    <a href={`/peminjaman/create/${laptop.id}`} className="btn btn-primary btn-sm">Pinjam</a>
  )}

  {laptop.status === "dipinjam" && (
    <button className="btn btn-secondary btn-sm" disabled>Dipinjam</button>
  )}

  {laptop.status === "diarsip" && (
    <button className="btn btn-success btn-sm" onClick={() => handleRestore(laptop.id)}>Kembalikan</button>
  )}

  {laptop.status === "tersedia" && (
    <>
      <a href={`/laptop/${laptop.id}/edit`} className="btn btn-warning btn-sm">Edit</a>
      <button className="btn btn-danger btn-sm" onClick={() => handleArchive(laptop.id)}>Arsip</button>
    </>
  )}
</td>

                </tr>
              ))
            )}
          </tbody>
        </table>

        {/* Toast container */}
        <ToastContainer position="top-right" autoClose={3000} />
      </div>

      <div className="d-flex justify-content-center gap-2 mt-2">
        <button disabled={!pagination.prev_page_url} onClick={() => fetchData(pagination.current_page - 1)} className="btn btn-outline-primary">Prev</button>
        <span>Halaman {pagination.current_page} dari {pagination.last_page}</span>
        <button disabled={!pagination.next_page_url} onClick={() => fetchData(pagination.current_page + 1)} className="btn btn-outline-primary">Next</button>
      </div>
    </div>
  );
}

// Render React 18/19
const container = document.getElementById("react-laptop-table");
if (container) {
  const root = ReactDOM.createRoot(container);
  root.render(<LaptopTable />);
}
