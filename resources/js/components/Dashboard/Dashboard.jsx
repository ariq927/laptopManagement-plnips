import React from 'react';
import Greeting from './Greeting.jsx';
import StatsCard from './StatsCard.jsx';
import LaptopChart from './LaptopChart.jsx';

export default function Dashboard({ user, totalLaptop, tersedia, diarsip, isGuest, laptopStats }) {
  return (
    <div className="row">
      <Greeting
        userName={user?.name}
        department={user?.department}
        email={user?.email}
        isGuest={isGuest}
      />

      <div className="col-12 mb-6">
        <div className="row justify-content-center">
          <StatsCard title="Total Laptop" value={totalLaptop} />
          <StatsCard title="Tersedia" value={tersedia} />
          <StatsCard title="Diarsip" value={diarsip} />
        </div>
      </div>

      <div className="col-12">
        <LaptopChart data={laptopStats} />
      </div>
    </div>
  );
}
