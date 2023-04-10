import { forwardRef, useEffect, useRef, useState } from 'react';

export default forwardRef(function Ruang(
    { name, id, value, message, className, required, isFocused, handleChange },
    ref
) {

    const input = ref ? ref : useRef();

    const [listRuang, setListRuang] = useState([])

    var arrayRuang = [];

    const getRuang = () => {
        
        var i;

        for (i = 1; i <= 33; i++) {
            arrayRuang.push({
                id: i,
                ruang: i
            });
        }

        setListRuang(arrayRuang);
    }


    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }
        
        getRuang()

    }, []);

    return (
        <div className='flex flex-col text-slate-600 capitalize'>
            <div>
                Ruang
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

                    <option value="">Pilih Ruang</option>

                    {listRuang.map((ruang, index) => (
                        <option key={index} value={ruang.id}>{ruang.ruang}</option>
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
