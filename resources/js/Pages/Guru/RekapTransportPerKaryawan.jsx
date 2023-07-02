import Bulan from '@/Components/Sia/Bulan'
import Guru from '@/Components/Sia/Guru'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, namaBulan, waktu } from '@/Functions/functions'
import getRekapTransportPerKaryawan from '@/Functions/getRekapTransportPerKaryawan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const RekapTransport = ({ initTahun, listUser }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM'),
        userId: '',
        listAbsensi: [],
        listTransport: []
    })

    async function getData() {
        const response = await getRekapTransportPerKaryawan(data.tahun, data.bulan, data.userId)
        setData({
            ...data,
            listAbsensi: response.listAbsensi,
            listTransport: response.listTransport
        })
    }
    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.bulan && data.userId) {
            trackPromise(getData())
        }

    }, [data.tahun, data.bulan, data.userId])
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

                <Guru
                    name='userId'
                    value={data.userId}
                    message={errors.userId}
                    handleChange={onHandleChange}
                    listUser={listUser}
                />

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