// eslint-disable-next-line no-unused-vars
import React from 'react';

import './Input.css';

const Input = ({ id, label, value, type, required, placeholder, handleChange, onFocus }) => {

    return (<>
        <div className="input-div">
            { label &&
                <label className="input-label">
                    {label}
                </label>
            }
            <input
                id={id}
                className="input-field"
                type={type}
                value={value}
                required={required}
                placeholder={placeholder}
                onChange={handleChange}
                onFocus={onFocus}
            />
        </div>
    </>);
};

export default Input;