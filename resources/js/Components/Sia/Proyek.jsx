import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function Proyek(
    { name, id, value, message, className, required, isFocused, handleChange, disabled, listProyek },
    ref
) {

    const input = ref ? ref : useRef()

    const uniqueProyeks = listProyek.filter((proyek, index, self) => {
        if (proyek.proyek_id) {
            return self.findIndex((p) => p.proyek_id == proyek.proyek_id) == index
        }
        return self.findIndex((p) => p.id == proyek.id) == index;
    })

    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }

    }, []);

    return (
        <div className='flex flex-col text-slate-600 capitalize'>
            <div>
                Proyek
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

                    <option value="">Pilih Proyek</option>

                    {uniqueProyeks.map((proyek, index) => (
                        <option key={index} value={proyek.proyek_id ?? proyek.id}>
                            {proyek.proyek?.nama ?? proyek.nama}
                        </option>
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
