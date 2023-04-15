import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function Checkbox(
    { name, value, handleChange,isFocused },
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
            className="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
            onChange={(e) => handleChange(e)}
        />
    );
})
