import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function CheckboxCheck(
    { name, value, handleChange, isFocused, checked },
    ref
) {

    const input = ref ? ref : useRef();

    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }

    }, []);

    return (
        <input
            type="checkbox"
            ref={input}
            name={name}
            value={value}
            checked={checked}
            className="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
            onChange={(e) => handleChange(e)}
        />
    );
})
