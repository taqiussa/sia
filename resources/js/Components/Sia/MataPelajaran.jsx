import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function MataPelajaran(
    { name, id, value, message, className, required, isFocused, handleChange, listMapel },
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
                mata pelajaran
            </div>
            <div>
                <select
                    name={name}
                    id={id}
                    value={value}
                    className={
                        `border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full ` +
                        className
                    }
                    ref={input}
                    required={required}
                    onChange={(e) => handleChange(e)}
                >

                    <option value="">Pilih Mata Pelajaran</option>

                    {listMapel.map((mapel, index) => (
                        <option key={index} value={mapel.mata_pelajaran_id ?? mapel.id}>{mapel.mapel ? mapel.mapel.nama : mapel.nama}</option>
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
