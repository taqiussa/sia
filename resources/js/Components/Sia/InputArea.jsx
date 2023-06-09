import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function InputArea(
    { type = 'text', name, id, value, message, className, required, isFocused, handleChange, label, rows },
    ref
) {

    const input = ref ? ref : useRef();

    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }

    }, []);

    return (
        <div className='flex flex-col text-slate-600 capitalize'>
            <div>
                {label}
            </div>
            <div>
                <textarea
                    name={name}
                    id={id}
                    rows={rows}
                    value={value}
                    className={
                        `border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full ` +
                        className
                    }
                    ref={input}
                    required={required}
                    onChange={(e) => handleChange(e)}
                >
                </textarea>
            </div>
            {message ?
                <div className='text-sm text-red-600'>
                    {message}
                </div>
                :
                null
            }
        </div>
    )
});
