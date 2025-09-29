import React from 'react';
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  Cell
} from 'recharts';

export default function LaptopChart({ data }) {
  if (!data || data.length === 0) {
    return <p className="text-center mt-4">Tidak ada data laptop</p>;
  }

  // Pastikan datanya sesuai format
  const chartData = data.map(item => ({
    merek: item.merek,
    total: item.total,
  }));

  // Fungsi untuk generate warna unik berdasarkan nama merek
  const getColorFromString = (str) => {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
      hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    // Konversi hash ke warna HSL supaya warnanya selalu konsisten
    const hue = Math.abs(hash) % 360;
    return `hsl(${hue}, 70%, 50%)`;
  };

  return (
    <div className="card mt-4 p-3 shadow rounded-xl">
      <h5 className="text-lg font-semibold mb-3">Jumlah Laptop per Merek</h5>
      <ResponsiveContainer width="100%" height={300}>
        <BarChart data={chartData}>
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="merek" />
          <YAxis />
          <Tooltip />
          <Bar dataKey="total" radius={[5, 5, 0, 0]}>
            {chartData.map((entry, index) => (
              <Cell key={`cell-${index}`} fill={getColorFromString(entry.merek)} />
            ))}
          </Bar>
        </BarChart>
      </ResponsiveContainer>
    </div>
  );
}
