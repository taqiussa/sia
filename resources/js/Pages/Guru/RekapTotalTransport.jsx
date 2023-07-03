import Bulan from '@/Components/Sia/Bulan'
import Tahun from '@/Components/Sia/Tahun'
import { namaBulan, penjumlahan } from '@/Functions/functions'
import { Head, router, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'

const RekapTotalTransport = ({ initTahun, listUser, maxHadir }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        bulan: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.bulan) {
            router.reload({
                only: ['listUser', 'maxHadir'],
                data: {
                    tahun: data.tahun,
                    bulan: data.bulan
                },
                preserveState: true,
                replace: true
            })
        }

    }, [data.tahun, data.bulan])
    return (
        <>
            <Head title='Rekap Total Transport' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap total transport bulan {namaBulan(data.bulan)}</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-2'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    id='bulan'
                    name='bulan'
                    value={data.bulan}
                    message={errors.bulan}
                    handleChange={onHandleChange}
                />

            </div>
            <div className="text-slate-600 py-3 font-bold capitalize">
                kehadiran terbanyak : {maxHadir}
            </div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                Kehadiran
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                Transport
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                % Kehadiran
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                % Transport
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listUser &&
                            listUser
                                .map((user, index) =>
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className={`py-2 px-2 font-medium text-slate-600 `}>
                                            {index + 1}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 `}>
                                            {user.name}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {penjumlahan(user.rekap_transports, 'hadir')}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {penjumlahan(user.rekap_transports, 'transport')}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {Number((penjumlahan(user.rekap_transports, 'hadir') / maxHadir) * 100).toFixed(2)} %
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {Number((penjumlahan(user.rekap_transports, 'transport') / maxHadir) * 100).toFixed(2)} %
                                        </td>
                                    </tr>
                                )}
                    </tbody>
                </table>
            </div>

        </>
    )
}

export default RekapTotalTransport