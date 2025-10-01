import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
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
      toast.success("Laptop berhasil diarsip");
      fetchData(pagination.current_page);
    } catch (err) {
      toast.error(err.message);
    }
  };

  const handleRestore = async (id) => {
    try {
      const res = await fetch(`/api/laptop/${id}/restore`, { method: "PATCH" });
      if (!res.ok) throw new Error("Gagal mengembalikan laptop");
      toast.success("Laptop berhasil dikembalikan");
      fetchData(pagination.current_page);
    } catch (err) {
      toast.error(err.message);
    }
  };

  // Generate page numbers
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

    // First page
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

    // Page numbers
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

    // Last page
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
        <h5 style={{ color: '#fff', fontWeight: 'bold', textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)' }}>Daftar Laptop</h5>
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

          <a href="/laptop/create" className="btn btn-primary" style={{ fontWeight: 'bold', whiteSpace: 'nowrap' }}>+ Tambah Laptop</a>
        </div>
      </div>

      <div className="table-responsive">
        <table className="table table-bordered" style={{ backgroundColor: 'transparent' }}>
          <thead style={{ backgroundColor: 'rgba(0, 0, 0, 0.6)' }}>
            <tr>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>No</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Merek</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Tipe</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Spesifikasi</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Nomor Seri</th>
              <th style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>Actions</th>
            </tr>
          </thead>
          <tbody>
            {laptops.length === 0 ? (
              <tr style={{ backgroundColor: 'rgba(255, 255, 255, 0.1)' }}>
                <td 
                  colSpan="6" 
                  className="text-center" 
                  style={{ 
                    color: '#fff', 
                    fontWeight: 'bold', 
                    textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)',
                    borderColor: 'rgba(255, 255, 255, 0.2)'
                  }}
                >
                  Belum ada data laptop
                </td>
              </tr>
            ) : (
              laptops.map((laptop, index) => (
                <tr 
                  key={laptop.id} 
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
                    {(pagination.from || 0) + index}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {laptop.merek}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {laptop.tipe}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {laptop.spesifikasi}
                  </td>
                  <td style={{ color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)', borderColor: 'rgba(255, 255, 255, 0.2)' }}>
                    {laptop.serial_number}
                  </td>
                  <td className="d-flex gap-1" style={{ borderColor: 'rgba(255, 255, 255, 0.2)' }}>
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
                        <a href={`/laptop/${laptop.id}/edit`} className="btn btn-warning btn-sm">Detail</a>
                        <button className="btn btn-danger btn-sm" onClick={() => handleArchive(laptop.id)}>Arsip</button>
                      </>
                    )}
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>

        <ToastContainer position="top-right" autoClose={3000} />
      </div>

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
    </div>
  );
}