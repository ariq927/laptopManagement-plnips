import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function PeminjamTable() {
  const [peminjams, setPeminjams] = useState([]);
  const [pagination, setPagination] = useState({});
  const [search, setSearch] = useState("");
  const [perPage, setPerPage] = useState(10);

  // Modal state
  const [showModal, setShowModal] = useState(false);
  const [selectedId, setSelectedId] = useState(null);

  const fetchData = async (page = 1) => {
    try {
      const res = await fetch(`/api/peminjam?search=${search}&page=${page}&per_page=${perPage}`);
      const data = await res.json();
      setPeminjams(data.data);
      setPagination(data);
    } catch (err) {
      toast.error("Gagal memuat data peminjam");
    }
  };

  useEffect(() => {
    fetchData();
  }, [search, perPage]);

  // Tampilkan modal konfirmasi
  const handleShowModal = (id) => {
    setSelectedId(id);
    setShowModal(true);
  };

  // Selesai peminjaman
  const handleSelesai = async () => {
    try {
      const res = await fetch(`/api/peminjam/${selectedId}/selesai`, { method: "DELETE" });
      if (!res.ok) throw new Error("Gagal menyelesaikan peminjaman");
      toast.success("Peminjaman selesai!");
      fetchData(pagination.current_page);
      setShowModal(false);
    } catch (err) {
      toast.error(err.message);
    }
  };

  return (
    <div>
      {/* Search & per page */}
      <div className="d-flex justify-content-between align-items-center mb-3">
  {/* Pencarian di kiri */}
  <input
    type="text"
    className="form-control"
    placeholder="Cari nama, departemen..."
    value={search}
    onChange={(e) => setSearch(e.target.value)}
    style={{ maxWidth: "300px", marginLeft: "10px" }}
  />

  {/* Dropdown per page di kanan dengan margin */}
  <select
    className="form-select"
    style={{ width: "100px", marginRight: "10px" }} // kasih jarak dari tabel
    value={perPage}
    onChange={(e) => setPerPage(Number(e.target.value))}
  >
    <option value="10">10 / halaman</option>
    <option value="20">20 / halaman</option>
    <option value="50">50 / halaman</option>
  </select>
</div>


      {/* Table */}
      <table className="table table-bordered">
        <thead className="table-dark">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Laptop</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {peminjams.length === 0 ? (
            <tr><td colSpan={7} className="text-center">Belum ada data peminjam</td></tr>
          ) : (
            peminjams.map((p, idx) => (
              <tr key={p.id}>
                <td>{(pagination.from || 0) + idx}</td>
                <td>{p.nama}</td>
                <td>{p.department ?? "-"}</td>
                <td>{p.laptop ? `${p.laptop.merek} ${p.laptop.tipe}` : "-"}</td>
                <td>{p.tanggal_mulai}</td>
                <td>{p.tanggal_selesai}</td>
                <td>
                  <button
                    className="btn btn-info btn-sm"
                    onClick={() => handleShowModal(p.id)}
                  >
                    Selesai
                  </button>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>

      {/* Pagination */}
      <div className="d-flex justify-content-center gap-2 mt-2">
        <button disabled={!pagination.prev_page_url} onClick={() => fetchData(pagination.current_page - 1)} className="btn btn-outline-primary">Prev</button>
        <span>Halaman {pagination.current_page} dari {pagination.last_page}</span>
        <button disabled={!pagination.next_page_url} onClick={() => fetchData(pagination.current_page + 1)} className="btn btn-outline-primary">Next</button>
      </div>

      {/* Toast container */}
      <ToastContainer position="top-right" autoClose={3000} />

      {/* Modal */}
      {showModal && (
        <div className="modal fade show d-block" style={{ backgroundColor: "rgba(0,0,0,0.5)" }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Konfirmasi</h5>
                <button type="button" className="btn-close" onClick={() => setShowModal(false)}></button>
              </div>
              <div className="modal-body">
                Yakin ingin menyelesaikan peminjaman ini?
              </div>
              <div className="modal-footer">
                <button className="btn btn-secondary" onClick={() => setShowModal(false)}>Batal</button>
                <button className="btn btn-primary" onClick={handleSelesai}>Ya, Selesai</button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

// Render React
const container = document.getElementById("react-peminjam-table");
if (container) {
  const root = ReactDOM.createRoot(container);
  root.render(<PeminjamTable />);
}
