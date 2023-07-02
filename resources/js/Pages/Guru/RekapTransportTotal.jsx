import Bulan from '@/Components/Sia/Bulan'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, namaBulan, penjumlahan, waktu } from '@/Functions/functions'
import getRekapTransport from '@/Functions/getRekapTransport'
import getRekapTransportTotal from '@/Functions/getRekapTransportTotal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const RekapTransportTotal = ({ initTahun }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM'),
        listUser: [],
        maxHadir: '',
    })

    async function getData() {
        const response = await getRekapTransportTotal(data.bulan, data.tahun)
        setData({
            ...data,
            listUser: response.listUser,
            maxHadir: response.maxHadir
        })
    }
    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.bulan) {
            trackPromise(getData())
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
                kehadiran terbanyak : {data.maxHadir}
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
                        {data.listUser &&
                            data.listUser
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
                                            {Number((penjumlahan(user.rekap_transports, 'hadir') / data.maxHadir) * 100).toFixed(2)} %
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {Number((penjumlahan(user.rekap_transports, 'transport') / data.maxHadir) * 100).toFixed(2)} %
                                        </td>
                                    </tr>
                                )}
                    </tbody>
                </table>
            </div>

        </>
    )
}

RekapTransportTotal.layout = page => <AppLayout children={page} />
export default RekapTransportTotal