import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function PeminjamTable() {
  const [peminjams, setPeminjams] = useState([]);
  const [pagination, setPagination] = useState({});
  const [search, setSearch] = useState("");
  const [perPage, setPerPage] = useState(10);

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

  const handleShowModal = (id) => {
    setSelectedId(id);
    setShowModal(true);
  };

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

  const renderPageNumbers = () => {
    const pages = [];
    const currentPage = pagination.current_page || 1;
    const lastPage = pagination.last_page || 1;
    const maxVisible = 5;

    let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
    let endPage = Math.min(lastPage, startPage + maxVisible - 1);

    if (endPage - startPage < maxVisible - 1) {
      startPage = Math.max(1, endPage - maxVisible + 1);
    }

    if (startPage > 1) {
      pages.push(
        <button
          key={1}
          onClick={() => fetchData(1)}
          className="btn btn-outline-light"
          style={{
            fontWeight: 'bold',
            width: '40px',
            height: '40px',
            borderRadius: '50%',
            padding: '0',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center'
          }}
        >
          1
        </button>
      );
      if (startPage > 2) {
        pages.push(
          <span key="dots1" style={{ color: '#fff', padding: '0 5px' }}>...</span>
        );
      }
    }

    for (let i = startPage; i <= endPage; i++) {
      pages.push(
        <button
          key={i}
          onClick={() => fetchData(i)}
          className="btn"
          style={{
            fontWeight: 'bold',
            width: '40px',
            height: '40px',
            borderRadius: '50%',
            padding: '0',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            backgroundColor: i === currentPage ? '#fff' : 'transparent',
            color: i === currentPage ? '#000' : '#fff',
            border: '1px solid rgba(255, 255, 255, 0.5)'
          }}
        >
          {i}
        </button>
      );
    }

    if (endPage < lastPage) {
      if (endPage < lastPage - 1) {
        pages.push(
          <span key="dots2" style={{ color: '#fff', padding: '0 5px' }}>...</span>
        );
      }
      pages.push(
        <button
          key={lastPage}
          onClick={() => fetchData(lastPage)}
          className="btn btn-outline-light"
          style={{
            fontWeight: 'bold',
            width: '40px',
            height: '40px',
            borderRadius: '50%',
            padding: '0',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center'
          }}
        >
          {lastPage}
        </button>
      );
    }

    return pages;
  };

  return (
    <div className="card" style={{ backgroundColor: 'rgba(255, 255, 255, 0.15)', backdropFilter: 'blur(10px)', border: '1px solid rgba(255, 255, 255, 0.2)' }}>
      <div className="card-header d-flex justify-content-between align-items-center" style={{ backgroundColor: 'rgba(0, 0, 0, 0.3)', borderBottom: '1px solid rgba(255, 255, 255, 0.2)' }}>
        <h5 style={{ color: '#fff', fontWeight: 'bold', textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)' }}>Daftar Peminjam</h5>
        <div className="d-flex gap-2">
          <select 
            className="form-select" 
            style={{ 
              width: "auto", 
              backgroundColor: 'rgba(255, 255, 255, 0.9)', 
              border: '1px solid rgba(255, 255, 255, 0.3)',
              color: '#000'
            }} 
            value={perPage} 
            onChange={(e) => setPerPage(Number(e.target.value))}
          >
            <option value="10">10 / halaman</option>
            <option value="20">20 / halaman</option>
            <option value="50">50 / halaman</option>
          </select>

          <input 
            type="text" 
            className="form-control" 
            placeholder="Cari nama, departemen..." 
            value={search} 
            onChange={(e) => setSearch(e.target.value)}
            style={{ 
              backgroundColor: 'rgba(255, 255, 255, 0.9)', 
              border: '1px solid rgba(255, 255, 255, 0.3)',
              color: '#000'
            }}
          />
        </div>
      </div>

      <div className="table-responsive">
        <table className="table table-bordered" style={{ backgroundColor: 'transparent' }}>
          <thead style={{ backgroundColor: 'rgba(0, 0, 0, 0.6)' }}>
            <tr>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>No</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Nama</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Departemen</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Laptop</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Tanggal Pinjam</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Tanggal Selesai</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {peminjams.length === 0 ? (
              <tr style={{ backgroundColor: 'rgba(255, 255, 255, 0.1)' }}>
                <td 
                  colSpan={7} 
                  className="text-center" 
                  style={{ 
                    color: '#fff', 
                    fontWeight: 'bold', 
                    textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)',
                    borderColor: 'rgba(255, 255, 255, 0.2)'
                  }}
                >
                  Belum ada data peminjam
                </td>
              </tr>
            ) : (
              peminjams.map((p, idx) => (
                <tr 
                  key={p.id} 
                  style={{ 
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    transition: 'all 0.3s ease',
                    cursor: 'pointer'
                  }}
                  onMouseEnter={(e) => {
                    e.currentTarget.style.backgroundColor = 'rgba(255, 255, 255, 0.25)';
                    e.currentTarget.style.transform = 'scale(1.02)';
                  }}
                  onMouseLeave={(e) => {
                    e.currentTarget.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
                    e.currentTarget.style.transform = 'scale(1)';
                  }}
                >
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {(pagination.from || 0) + idx}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {p.nama}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {p.department ?? "-"}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {p.laptop ? `${p.laptop.merek} ${p.laptop.tipe}` : "-"}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {p.tanggal_mulai}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {p.tanggal_selesai}
                  </td>
                  <td style={{ borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    <button
                      className="btn btn-sm"
                      onClick={() => handleShowModal(p.id)}
                      style={{
                        backgroundColor: '#14a2ba',
                        color: '#fff',
                        border: 'none',
                        fontWeight: 'bold',
                        padding: '6px 16px',
                        borderRadius: '4px',
                        transition: 'all 0.3s ease'
                      }}
                      onMouseEnter={(e) => {
                        e.currentTarget.style.backgroundColor = '#0f8399';
                        e.currentTarget.style.transform = 'scale(1.05)';
                      }}
                      onMouseLeave={(e) => {
                        e.currentTarget.style.backgroundColor = '#14a2ba';
                        e.currentTarget.style.transform = 'scale(1)';
                      }}
                    >
                      Selesai
                    </button>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>

        <ToastContainer position="top-right" autoClose={3000} />
      </div>

      {/* Pagination */}
      <div className="d-flex justify-content-between align-items-center mt-3" style={{ padding: '10px 20px' }}>
        <span style={{ color: '#fff', fontWeight: 'bold', textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)' }}>
          Menampilkan {pagination.from || 0} - {pagination.to || 0} dari {pagination.total || 0} data
        </span>

        <div className="d-flex gap-2 align-items-center">
          <button 
            disabled={!pagination.prev_page_url} 
            onClick={() => fetchData(pagination.current_page - 1)} 
            className="btn btn-outline-light"
            style={{ 
              fontWeight: 'bold',
              width: '40px',
              height: '40px',
              borderRadius: '50%',
              padding: '0',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center'
            }}
          >
            ‹
          </button>

          {renderPageNumbers()}

          <button 
            disabled={!pagination.next_page_url} 
            onClick={() => fetchData(pagination.current_page + 1)} 
            className="btn btn-outline-light"
            style={{ 
              fontWeight: 'bold',
              width: '40px',
              height: '40px',
              borderRadius: '50%',
              padding: '0',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center'
            }}
          >
            ›
          </button>
        </div>
      </div>

      {/* Modal */}
      {showModal && (
        <div className="modal fade show d-block" style={{ backgroundColor: "rgba(0,0,0,0.7)", backdropFilter: 'blur(5px)' }}>
          <div className="modal-dialog">
            <div className="modal-content" style={{ backgroundColor: 'rgba(255, 255, 255, 0.95)', border: '1px solid rgba(255, 255, 255, 0.3)' }}>
              <div className="modal-header" style={{ borderBottom: '1px solid rgba(0, 0, 0, 0.1)' }}>
                <h5 className="modal-title" style={{ fontWeight: 'bold' }}>Konfirmasi</h5>
                <button type="button" className="btn-close" onClick={() => setShowModal(false)}></button>
              </div>
              <div className="modal-body" style={{ fontWeight: '500' }}>
                Yakin ingin menyelesaikan peminjaman ini?
              </div>
              <div className="modal-footer" style={{ borderTop: '1px solid rgba(0, 0, 0, 0.1)' }}>
                <button className="btn btn-secondary me-2 mt-2" onClick={() => setShowModal(false)}>Batal</button>
                <button className="btn btn-primary mt-2" onClick={handleSelesai}>Ya, Selesai</button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
