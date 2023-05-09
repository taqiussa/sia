import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function RadioButton(
    { name, value, handleChange, isFocused, label },
    ref
) {

    const input = ref ? ref : useRef();

    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }

    }, []);

    return (
        <div className='inline-flex items-center space-x-2 capitalize'>
            <input
                type="radio"
                ref={input}
                name={name}
                value={value}
                className="rounded-full border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                onChange={(e) => handleChange(e)}
            />
            <div>
                {label}
            </div>
        </div>
    );
})
