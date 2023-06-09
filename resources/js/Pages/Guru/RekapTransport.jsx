import Bulan from '@/Components/Sia/Bulan'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, namaBulan, penjumlahan, waktu } from '@/Functions/functions'
import getRekapTransport from '@/Functions/getRekapTransport'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm, usePage } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const RekapTransport = ({ initTahun }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM'),
        listAbsensi: [],
        listTransport: [],
        maxHadir: '',
    })

    async function getData() {
        const response = await getRekapTransport(data.tahun, data.bulan)
        setData({
            ...data,
            listAbsensi: response.listAbsensi,
            listTransport: response.listTransport,
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
            <Head title='Rekap Transport Karyawan' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap transport guru dan karyawan bulan {namaBulan(data.bulan)}</div>
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
            <div className="text-slate-600 py-3 font-bold capitalize flex flex-col space-y-3">
                <div>
                    kehadiran terbanyak : {data.maxHadir}
                </div>
                <div>
                    kehadiran : {penjumlahan(data.listTransport, 'hadir')} ({Number((penjumlahan(data.listTransport, 'hadir') / data.maxHadir) * 100).toFixed(2)} %)
                </div>
                <div>
                    transport : {penjumlahan(data.listTransport, 'transport')} ({Number((penjumlahan(data.listTransport, 'transport') / data.maxHadir) * 100).toFixed(2)} %)
                </div>
            </div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Hari, Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                Masuk
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                Pulang
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                Kehadiran
                            </th>
                            <th scope='col' className="py-3 px-2 ">
                                Transport
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listTransport &&
                            data.listTransport
                                .map((transport, index) =>
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className={`py-2 px-2 font-medium text-slate-600 `}>
                                            {index + 1}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 `}>
                                            {hariTanggal(transport.tanggal)}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {data.listAbsensi && data.listAbsensi
                                                .filter(absensi => absensi.tanggal == transport.tanggal)
                                                .map(absensi => waktu(absensi.masuk))
                                            }
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {data.listAbsensi && data.listAbsensi
                                                .filter(absensi => absensi.tanggal == transport.tanggal)
                                                .map(absensi => absensi.pulang ? waktu(absensi.pulang) : null)
                                            }
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600  text-center`}>
                                            {transport.hadir}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 text-center `}>
                                            {transport.transport}
                                        </td>
                                    </tr>
                                )}
                    </tbody>
                </table>
            </div>

        </>
    )
}

RekapTransport.layout = page => <AppLayout children={page} />
export default RekapTransport