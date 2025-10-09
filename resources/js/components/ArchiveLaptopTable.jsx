import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function ArchiveLaptopTable() {
  const [laptops, setLaptops] = useState([]);
  const [pagination, setPagination] = useState({});
  const [search, setSearch] = useState("");
  const [perPage, setPerPage] = useState(10);

  const fetchData = async (page = 1) => {
    try {
      const res = await fetch(`/api/laptop/arsip?search=${search}&page=${page}&per_page=${perPage}`);
      const json = await res.json();
      setLaptops(json.data);
      setPagination(json);
    } catch (err) {
      toast.error("Gagal mengambil data laptop");
    }
  };

  useEffect(() => {
    fetchData();
  }, [search, perPage]);

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

  const renderPageNumbers = () => {
    const pages = [];
    const currentPage = pagination.current_page || 1;
    const lastPage = pagination.last_page || 1;
    const maxVisible = 5;

    let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
    let endPage = Math.min(lastPage, startPage + maxVisible - 1);
    if (endPage - startPage < maxVisible - 1) startPage = Math.max(1, endPage - maxVisible + 1);

    if (startPage > 1) {
      pages.push(<button key={1} onClick={() => fetchData(1)} className="btn btn-outline-light" style={pageBtnStyle}>1</button>);
      if (startPage > 2) pages.push(<span key="dots1" style={dotsStyle}>...</span>);
    }

    for (let i = startPage; i <= endPage; i++) {
      pages.push(
        <button key={i} onClick={() => fetchData(i)} className="btn" style={{ ...pageBtnStyle, backgroundColor: i === currentPage ? "#fff" : "transparent", color: i === currentPage ? "#000" : "#fff" }}>{i}</button>
      );
    }

    if (endPage < lastPage) {
      if (endPage < lastPage - 1) pages.push(<span key="dots2" style={dotsStyle}>...</span>);
      pages.push(<button key={lastPage} onClick={() => fetchData(lastPage)} className="btn btn-outline-light" style={pageBtnStyle}>{lastPage}</button>);
    }

    return pages;
  };

  return (
    <div className="card" style={cardStyle}>
      <div className="card-header d-flex justify-content-between align-items-center" style={headerStyle}>
        <h5 style={titleStyle}>Laptop Diarsip</h5>
        <div className="d-flex gap-2">
          <select className="form-select" style={selectStyle} value={perPage} onChange={(e) => setPerPage(Number(e.target.value))}>
            <option value="10">10 / halaman</option>
            <option value="25">25 / halaman</option>
            <option value="50">50 / halaman</option>
            <option value="100">100 / halaman</option>
          </select>
          <input type="text" className="form-control" placeholder="Cari Laptop.." value={search} onChange={(e) => setSearch(e.target.value)} style={inputStyle} />
        </div>
      </div>

      <div className="table-responsive">
        <table className="table table-bordered" style={{ backgroundColor: 'transparent' }}>
          <thead style={{ backgroundColor: 'rgba(0,0,0,0.6)' }}>
            <tr>
              <th style={thStyle}>No</th>
              <th style={thStyle}>Merek - Tipe</th>
              <th style={thStyle}>Serial Number</th>
              <th style={thStyle}>Spesifikasi</th>
              <th style={thStyle}>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {laptops.length === 0 ? (
              <tr style={trStyle}>
                <td colSpan="5" style={emptyStyle}>Belum ada data laptop</td>
              </tr>
            ) : (
              laptops.map((laptop, index) => (
                <tr key={laptop.id} style={trStyle}>
                  <td style={tdStyle}>{(pagination.from || 0) + index}</td>
                  <td style={tdStyle}>{laptop.merek} {laptop.tipe}</td>
                  <td style={tdStyle}>{laptop.serial_number}</td>
                  <td style={tdStyle}>{laptop.spesifikasi}</td>
                  <td style={{ borderColor: 'rgba(255,255,255,0.2)' }}>
                    <button className="btn btn-success btn-sm" onClick={() => handleRestore(laptop.id)}>Kembalikan</button>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
        <ToastContainer position="top-right" autoClose={3000} />
      </div>

      <div className="d-flex justify-content-between align-items-center mt-3" style={{ padding: '10px 20px' }}>
        <span style={titleStyle}>
          Menampilkan {pagination.from || 0} - {pagination.to || 0} dari {pagination.total || 0} data
        </span>
        <div className="d-flex gap-2 align-items-center">
          <button disabled={!pagination.prev_page_url} onClick={() => fetchData(pagination.current_page - 1)} className="btn btn-outline-light" style={pageBtnStyle}>‹</button>
          {renderPageNumbers()}
          <button disabled={!pagination.next_page_url} onClick={() => fetchData(pagination.current_page + 1)} className="btn btn-outline-light" style={pageBtnStyle}>›</button>
        </div>
      </div>
    </div>
  );
}

// Styles
const cardStyle = { backgroundColor: 'rgba(255,255,255,0.15)', backdropFilter: 'blur(10px)', border: '1px solid rgba(255,255,255,0.2)' };
const headerStyle = { backgroundColor: 'rgba(0,0,0,0.3)', borderBottom: '1px solid rgba(255,255,255,0.2)' };
const titleStyle = { color: '#fff', fontWeight: 'bold', textShadow: '2px 2px 4px rgba(0,0,0,0.8)' };
const thStyle = { color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 2px rgba(0,0,0,0.8)', borderColor: 'rgba(255,255,255,0.2)' };
const tdStyle = { color: '#fff', fontWeight: 'bold', textShadow: '1px 1px 3px rgba(0,0,0,0.8)', borderColor: 'rgba(255,255,255,0.2)' };
const trStyle = { backgroundColor: 'rgba(255,255,255,0.1)', transition: 'all 0.3s ease' };
const emptyStyle = { color: '#fff', fontWeight: 'bold', textShadow: '2px 2px 4px rgba(0,0,0,0.8)', borderColor: 'rgba(255,255,255,0.2)' };
const selectStyle = { width: "auto", backgroundColor: 'rgba(255,255,255,0.9)', border: '1px solid rgba(255,255,255,0.3)', color: '#000' };
const inputStyle = { backgroundColor: 'rgba(255,255,255,0.9)', border: '1px solid rgba(255,255,255,0.3)', color: '#000' };
const pageBtnStyle = { fontWeight: 'bold', width: '40px', height: '40px', borderRadius: '50%', padding: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', border: '1px solid rgba(255,255,255,0.5)' };
const dotsStyle = { color: '#fff', padding: '0 5px' };

document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('archive-laptop-table');
  if (el) {
    const root = ReactDOM.createRoot(el);
    root.render(<ArchiveLaptopTable />);
  }
});
