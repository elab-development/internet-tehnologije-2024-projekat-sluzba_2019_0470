import React, { useState, useEffect } from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import Navigation from './reusable/Navigation';
import LoginPage from './auth/LoginPage';
import RegisterPage from './auth/RegisterPage';
import Home from './student/Home';
import HomeSluzbenik from './sluzbenik/HomeSluzbenik';
import './App.css';
import Footer from './reusable/Footer';

function App() {
  const [user, setUser] = useState(null);
  const [accessToken, setAccessToken] = useState(null);

  useEffect(() => {
    const token = sessionStorage.getItem('access_token');
    const storedUser = sessionStorage.getItem('user');
    if (token && storedUser) {
      setAccessToken(token);
      setUser(JSON.parse(storedUser));
    }
  }, []);

  const handleLoginSuccess = ({ access_token, user }) => {
    setAccessToken(access_token);
    setUser(user);
  };

  const handleLogout = () => {
    setUser(null);
    setAccessToken(null);
    sessionStorage.removeItem('access_token');
    sessionStorage.removeItem('user');
  };

  return (
    <BrowserRouter>
      {user && <Navigation user={user} onLogout={handleLogout} />}

      <Routes>
        {/* Ako nije ulogovan, šalje na Login */}
        {!user && (
          <>
            <Route path="/" element={<LoginPage onLoginSuccess={handleLoginSuccess} />} />
            <Route path="/register" element={<RegisterPage />} />
          </>
        )}

        {/* Ako je ulogovan student */}
        {user && user.role === 'student' && (
          <>
            <Route path="/home" element={<Home />} />
            
          </>
        )}

        {/* Ako je ulogovan službenik */}
        {user && user.role === 'sluzbenik' && (
          <>
            <Route path="/sluzbenik/home" element={<HomeSluzbenik />} />
          </>
        )}
      </Routes>
      <Footer/>
    </BrowserRouter>
  );
}

export default App;
