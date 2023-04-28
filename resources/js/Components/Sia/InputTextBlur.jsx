import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function InputTextBlur(
    { type = 'text', name, id, value, message, className, required, isFocused, handleChange, handleBlur, label },
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
                <input
                    type={type}
                    name={name}
                    id={id}
                    value={value}
                    className={
                        className ?
                            `border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm ` + className
                            :
                            `border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full `
                    }
                    ref={input}
                    required={required}
                    onChange={(e) => handleChange(e)}
                    onBlur={(e) => handleBlur(e)}
                />

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
