import React, { useState } from 'react';
import axios from 'axios';
import { FaBars, FaTimes, FaHome, FaBook, FaClipboardList, FaUsers, FaSignOutAlt } from 'react-icons/fa';
import { Link } from 'react-router-dom';

const linksByRole = {
  student: [
    { to: '/', label: 'Početna', icon: <FaHome /> },
    { to: '/predmeti', label: 'Predmeti', icon: <FaBook /> },
    { to: '/prijave', label: 'Prijava ispita', icon: <FaClipboardList /> },
  ],
  sluzbenik: [
    { to: '/studenti', label: 'Studenti', icon: <FaUsers /> },
    { to: '/predmeti', label: 'Predmeti', icon: <FaBook /> },
    { to: '/prijave', label: 'Prijave ispita', icon: <FaClipboardList /> },
  ],
};

function Navigation({ user, onLogout }) {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  const toggleSidebar = () => setSidebarOpen(prev => !prev);

  const handleLogoutClick = async () => {
    try {
      const token = sessionStorage.getItem('access_token');
      await axios.post('http://127.0.0.1:8000/api/logout', {}, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        }
      });

      alert('Uspešno ste se odjavili.');
      sessionStorage.removeItem('access_token');
      sessionStorage.removeItem('user');
      onLogout();

    } catch (error) {
      alert('Došlo je do greške prilikom odjave.');
      console.error(error);
    }
  };

  const links = linksByRole[user.role] || [];

  return (
    <>
      {/* Top bar sa toggle dugmetom i brandom */}
      <header className="topbar">
        <button className="toggle-button" onClick={toggleSidebar}>
          {sidebarOpen ? <FaTimes size={24} /> : <FaBars size={24} />}
        </button>
        <span className="brand">Examify</span>
        <div className="user-info">
          Dobrodošli, {user.ime} {user.prezime} ({user.role})
        </div>
        <button className="button logout-button" onClick={handleLogoutClick}>
          Odjavi se
        </button>
      </header>

      {/* Sidebar meni */}
      <nav className={`sidebar ${sidebarOpen ? 'open' : ''}`}>
        {links.map(({ to, label, icon }) => (
          <Link key={to} to={to} className="sidebar-link" onClick={() => setSidebarOpen(false)}>
            <span className="icon">{icon}</span>
            <span className="label">{label}</span>
          </Link>
        ))}
      </nav>

      {/* Overlay kad je sidebar otvoren (za zatvaranje klikom van) */}
      {sidebarOpen && <div className="sidebar-overlay" onClick={toggleSidebar}></div>}
    </>
  );
}

export default Navigation;
