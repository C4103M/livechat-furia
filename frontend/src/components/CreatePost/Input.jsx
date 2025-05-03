import React from 'react';

function Input({ label, type = "text", name, value, onChange, placeholder }) {
  return (
    <div className="mb-4 flex flex-col">
      {label && <label htmlFor={name} className="mb-1 font-semibold ">{label}</label>}
      <input
        type={type}
        id={name}
        name={name}
        value={value}
        onChange={onChange}
        placeholder={placeholder}
        className="border-2 border-[var(--main-border-color)] rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        required
      />
    </div>
  );
}

export default Input;
