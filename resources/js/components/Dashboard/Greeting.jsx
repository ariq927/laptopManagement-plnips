import React from 'react';

export default function Greeting({ userName, department, email, isGuest }) {
  return (
    <div className="col-12 mb-6">
      <div className="card p-3">
        <h3>Hi, {isGuest ? 'Guest' : userName}!</h3>
        <p>Department: {isGuest ? '-' : department}</p>
        <p>Email: {isGuest ? '-' : email}</p>
      </div>
    </div>
  );
}
