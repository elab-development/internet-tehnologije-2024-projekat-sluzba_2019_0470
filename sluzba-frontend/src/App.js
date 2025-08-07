import React, { useState, useEffect } from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Navigation from './reusable/Navigation';
import Home from './auth/Home';
import Login from './auth/LoginPage';
import './App.css';

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

  if (!user) {
    return (
      <BrowserRouter>
        <Login onLoginSuccess={handleLoginSuccess} />
      </BrowserRouter>
    );
  }

  return (
    <BrowserRouter>
      <Navigation user={user} onLogout={handleLogout} />
      <main style={{ marginTop: '56px', padding: '2rem' }}>
        <Routes>
          <Route path="/" element={<Home />} />
          {/* Ostale rute po potrebi */}
        </Routes>
      </main>
    </BrowserRouter>
  );
}

export default App;
