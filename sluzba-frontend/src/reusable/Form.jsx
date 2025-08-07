import React, { useState } from 'react';

function Form({ title, fields, onSubmit, loading, error }) {
  // Lokalni state za vrednosti polja
  const [formData, setFormData] = useState(() => {
    const initialData = {};
    fields.forEach(f => { initialData[f.name] = ''; });
    return initialData;
  });

  // Promena vrednosti inputa
  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  // Submit forme
  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };

  return (
    <form onSubmit={handleSubmit} className="form-container" noValidate>
      <h2 style={{ color: 'var(--white)' }}>{title}</h2>

      {fields.map(({ label, name, type, placeholder }, i) => (
        <div key={i} className="form-group">
          <label htmlFor={name} style={{ color: 'var(--white)' }}>{label}</label>
          <input
            id={name}
            name={name}
            type={type}
            placeholder={placeholder}
            value={formData[name]}
            onChange={handleChange}
            required
          />
        </div>
      ))}

      {error && <div className="error-message">{error}</div>}

      <button type="submit" disabled={loading}>
        {loading ? 'Učitavanje...' : title}
      </button>
    </form>
  );
}

export default Form;