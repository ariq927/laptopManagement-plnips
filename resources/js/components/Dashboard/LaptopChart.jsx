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
    return (
      <p 
        className="text-center mt-4" 
        style={{ 
          color: '#fff', 
          fontWeight: 'bold', 
          textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)' 
        }}
      >
        Tidak ada data laptop
      </p>
    );
  }

  const chartData = data.map(item => ({
    merek: item.merek,
    total: item.total,
  }));

  const getColorFromString = (str) => {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
      hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    const hue = Math.abs(hash) % 360;
    return `hsl(${hue}, 70%, 50%)`;
  };

  const CustomTooltip = ({ active, payload }) => {
    if (active && payload && payload.length) {
      return (
        <div 
          style={{ 
            backgroundColor: 'rgba(20, 162, 186, 0.9)', 
            backdropFilter: 'blur(10px)',
            padding: '10px', 
            border: '1px solid rgba(20, 162, 186, 0.5)',
            borderRadius: '5px'
          }}
        >
          <p style={{ 
            color: '#fff', 
            margin: 0, 
            fontWeight: 'bold',
            textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)'
          }}>
            {payload[0].payload.merek}
          </p>
          <p style={{ 
            color: '#fff', 
            margin: 0,
            textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)'
          }}>
            Total: {payload[0].value}
          </p>
        </div>
      );
    }
    return null;
  };

  return (
    <div 
      className="card mt-4 p-3" 
      style={{ 
        backgroundColor: 'rgba(20, 162, 186, 0.25)', 
        backdropFilter: 'blur(10px)', 
        border: '1px solid rgba(20, 162, 186, 0.4)',
        boxShadow: '0 8px 16px rgba(0, 0, 0, 0.3)',
        borderRadius: '12px'
      }}
    >
      <h5 
        style={{ 
          color: '#fff', 
          fontWeight: 'bold', 
          textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)',
          fontSize: '1.2rem',
          marginBottom: '15px'
        }}
      >
        Jumlah Laptop Berdasarkan Merek
      </h5>
      <ResponsiveContainer width="100%" height={300}>
        <BarChart data={chartData}>
          <CartesianGrid strokeDasharray="3 3" stroke="rgba(20, 162, 186, 0.3)" />
          <XAxis 
            dataKey="merek" 
            tick={{ 
              fill: '#fff', 
              fontWeight: 'bold',
              textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)'
            }}
            stroke="rgba(20, 162, 186, 0.6)"
          />
          <YAxis 
            tick={{ 
              fill: '#fff', 
              fontWeight: 'bold',
              textShadow: '1px 1px 2px rgba(0, 0, 0, 0.8)'
            }}
            stroke="rgba(20, 162, 186, 0.6)"
          />
          <Tooltip content={<CustomTooltip />} />
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