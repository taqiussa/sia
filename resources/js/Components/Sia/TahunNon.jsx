import { forwardRef, useEffect, useRef, useState } from 'react';
import moment from 'moment'

export default forwardRef(function TahunNon(
    { name, id, value, message, className, required, isFocused, handleChange },
    ref
) {
    const [listTahun, setListTahun] = useState([]);

    let arrTahun = [];

    const arrayTahun = () => {
        let i;
        for (i = 2022; i <= Number(moment(new Date()).format('YYYY')); i++) {
            arrTahun.push({
                id: i,
                tahun: i
            });
        }
        setListTahun(arrTahun);
    }


    const input = ref ? ref : useRef();

    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }

        arrayTahun();

    }, []);

    return (
        <div className='flex flex-col text-slate-600 capitalize'>
            <div>
                tahun
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

                    <option value="">Pilih Tahun</option>

                    {listTahun.map((tahun, index) => (
                        <option key={index} value={tahun.tahun}>{tahun.tahun}</option>
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
