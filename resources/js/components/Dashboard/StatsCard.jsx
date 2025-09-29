import React from "react";
import CountUp from "react-countup";
import '../../../assets/vendor/scss/_theme/_theme.scss'; // path benar

export default function StatsCard({ title, value }) {
  return (
    <div className="col-lg-4 col-md-6 mb-6">
      <div className="card stats-card h-100 shadow-sm">
        <div className="card-body d-flex flex-column align-items-center justify-content-center text-center">
          <p>{title}</p>
          <h4 className="card-title">
            <CountUp end={value} duration={1.5} />
          </h4>
        </div>
      </div>
    </div>
  );
}
