import React from 'react';

export default function Greeting({ userName, department, email, isGuest }) {
  return (
    <div className="col-12 mb-6">
      <div 
        className="card p-3" 
        style={{ 
          backgroundColor: 'rgba(20, 162, 186, 0.50)', 
          backdropFilter: 'blur(10px)', 
          border: '1px solid rgba(20, 162, 186, 0.4)',
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
          e.currentTarget.style.boxShadow = 'none';
        }}
      >
        <h3 style={{ 
          color: '#fff', 
          fontWeight: 'bold', 
          textShadow: '2px 2px 4px rgba(0, 0, 0, 0.8)',
          marginBottom: '10px'
        }}>
          Hi, {isGuest ? 'Guest' : userName}!
        </h3>
        <p style={{ 
          color: '#fff', 
          fontWeight: '500', 
          textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)',
          marginBottom: '5px'
        }}>
          Department: {isGuest ? '-' : department}
        </p>
        <p style={{ 
          color: '#fff', 
          fontWeight: '500', 
          textShadow: '1px 1px 3px rgba(0, 0, 0, 0.8)',
          marginBottom: '0'
        }}>
          Email: {isGuest ? '-' : email}
        </p>
      </div>
    </div>
  );
} 