import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function Kategori(
    { name, id, value, message, className, required, isFocused, handleChange, listKategori, label },
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
                Kategori {label}
            </div>
            <div>
                <select
                    name={name}
                    id={id}
                    value={value}
                    className={
                        `border-gray-300 capitalize focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full ` +
                        className
                    }
                    ref={input}
                    required={required}
                    onChange={(e) => handleChange(e)}
                >

                    <option value="">Pilih Kategori {label}</option>

                    {listKategori.map((kategori, index) => (
                        <option key={index} value={kategori.id}>{kategori.nama}</option>
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
