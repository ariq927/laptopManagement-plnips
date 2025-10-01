import React from "react";
import CountUp from "react-countup";
import '../../../assets/vendor/scss/_theme/_theme.scss'; // path benar

export default function StatsCard({ title, value }) {
  return (
    <div className="col-lg-4 col-md-6 mb-6">
      <div 
        className="card stats-card h-100" 
        style={{ 
          backgroundColor: 'rgba(20, 162, 186, 0.50)', 
          backdropFilter: 'blur(10px)', 
          border: '1px solid rgba(20, 162, 186, 0.4)',
          boxShadow: '0 8px 16px rgba(0, 0, 0, 0.3)',
          transition: 'all 0.3s ease',
          cursor: 'pointer'
        }}
        onMouseEnter={(e) => {
          e.currentTarget.style.backgroundColor = 'rgba(20, 162, 186, 0.4)';
          e.currentTarget.style.transform = 'translateY(-5px)';
          e.currentTarget.style.boxShadow = '0 12px 24px rgba(20, 162, 186, 0.3)';
        }}
        onMouseLeave={(e) => {
          e.currentTarget.style.backgroundColor = 'rgba(20, 162, 186, 0.25)';
          e.currentTarget.style.transform = 'translateY(0)';
          e.currentTarget.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.3)';
        }}
      >
        <div className="card-body d-flex flex-column align-items-center justify-content-center text-center">
          <p style={{ 
            color: '#fff', 
            fontWeight: '600', 
            textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)',
            marginBottom: '10px',
            fontSize: '1.1rem'
          }}>
            {title}
          </p>
          <h4 
            className="card-title" 
            style={{ 
              color: '#fff', 
              fontWeight: 'bold', 
              textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)',
              fontSize: '2.5rem',
              marginBottom: '0'
            }}
          >
            <CountUp end={value} duration={1.5} />
          </h4>
        </div>
      </div>
    </div>
  );
}