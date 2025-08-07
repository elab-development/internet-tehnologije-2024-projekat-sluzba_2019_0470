import React, { useState } from 'react';
import Form from '../reusable/Form';
import axios from 'axios';

function Login({ onLoginSuccess }) {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const fields = [
    { label: 'Email', name: 'email', type: 'email', placeholder: 'Unesite email' },
    { label: 'Lozinka', name: 'password', type: 'password', placeholder: 'Unesite lozinku' },
  ];

 const handleSubmit = async (data) => {
    setLoading(true);
    setError(null);

    try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', data, {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        });

        const { access_token, user } = response.data;

        // Čuvamo u sessionStorage
        sessionStorage.setItem('access_token', access_token);
        sessionStorage.setItem('user', JSON.stringify(user));

        // Prosleđujemo roditeljskoj komponenti (App.js)
        onLoginSuccess({ access_token, user });

    } catch (err) {
        setError(err.response?.data?.message || 'Greška pri prijavi.');
    } finally {
        setLoading(false);
    }
    };


  return (
    <Form
      title="Prijava"
      fields={fields}
      onSubmit={handleSubmit}
      loading={loading}
      error={error}
    />
  );
}

export default Login;