import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function Kurikulum(
    { name, id, value, message, className, required, isFocused, handleChange, disabled, listKurikulum },
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
                kurikulum
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

                    <option value="">Pilih Kurikulum</option>

                    {listKurikulum.map((kurikulum, index) => (
                        <option key={index} value={kurikulum.kurikulum_id ?? kurikulum.id}>{kurikulum.kurikulum?.nama ?? kurikulum.nama}</option>
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
