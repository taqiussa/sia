import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function SubElemen(
    { name, id, value, message, className, required, isFocused, handleChange, disabled, listSubElemen },
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
                sub elemen
            </div>
            <div>
                <select
                    name={name}
                    id={id}
                    value={value}
                    className={
                        `border-gray-300  focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full ${disabled && 'bg-slate-200'
                        } ` +
                        className
                    }
                    ref={input}
                    required={required}
                    onChange={(e) => handleChange(e)}
                    disabled={disabled}
                >

                    <option value="">Pilih Sub Elemen</option>

                    {listSubElemen.map((sub, index) => (
                        <option key={index} value={sub.id}>{sub.nama}</option>
                    ))}

                </select>
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
