import React from 'react';

function Home() {
  return (
    <div className="home">
      <h1>Dobrodošli u Examify za studente</h1>
      <p>Ovde možete pregledati sve predmete, prijaviti ispit i videti detaljnije metrike.</p>

      <div className="cards-container">
        <div className="card">
          <img src="/prezentacija.jpg" alt="Prezentacija" className="card-image" />
          <h3>O Prezentacijama</h3>
          <p>
            Prezentacije na fakultetu pružaju pregled ključnih oblasti i održavaju se na mesečnom nivou.
          </p>
        </div>

        <div className="card">
          <img src="/studenti.webp" alt="Studenti" className="card-image" />
          <h3>O Studentima</h3>
          <p>
            Studenti su srce fakulteta – ovde se neguje njihova kreativnost, rad i zajedništvo.
          </p>
        </div>
      </div>
    </div>
  );
}

export default Home;
