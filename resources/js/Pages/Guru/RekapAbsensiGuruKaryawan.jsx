import Bulan from '@/Components/Sia/Bulan'
import TahunNon from '@/Components/Sia/TahunNon'
import { hariTanggal, namaBulan, waktu } from '@/Functions/functions'
import getRekapAbsensiGuruKaryawan from '@/Functions/getRekapAbsensiGuruKaryawan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const RekapAbsensiGuruKaryawan = () => {

    const { data, setData, errors, processing } = useForm({
        tahun: moment(new Date()).format('YYYY'),
        bulan: moment(new Date()).format('MM'),
        listAbsensi: []
    })

    async function getData() {
        const response = await getRekapAbsensiGuruKaryawan(data.tahun, data.bulan)
        setData({ ...data, listAbsensi: response.listAbsensi })
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
            <Head title='Rekap Absensi Karyawan' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap absensi guru dan karyawan bulan {namaBulan(data.bulan)}</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-2'>

                <TahunNon
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
                        {data.listAbsensi &&
                            data.listAbsensi.map((absensi, index) => {
                                const isTerlambat = moment(absensi.masuk, 'YYYY-MM-DD HH:mm:ss').isAfter(moment(absensi.masuk).set({ hour: 7, minute: 0, second: 0 }), 'second')
                                const isJumat = moment(absensi.tanggal).day() == 5
                                const isAwal = isJumat
                                    ? moment(absensi.pulang, 'YYYY-MM-DD HH:mm:ss').isBefore(moment(absensi.pulang).set({ hour: 10, minute: 30, second: 0 }), 'second')
                                    : moment(absensi.pulang, 'YYYY-MM-DD HH:mm:ss').isBefore(moment(absensi.pulang).set({ hour: 13, minute: 0, second: 0 }), 'second')
                                return (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className={`py-2 px-2 font-medium text-slate-600 `}>
                                            {index + 1}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 `}>
                                            {absensi.tanggal ? hariTanggal(absensi.tanggal) : null}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 text-center ${isTerlambat ? 'bg-red-600 text-white' : ''}`}>
                                            {absensi.masuk ? waktu(absensi.masuk) : null}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 text-center ${isAwal ? 'bg-red-600 text-white' : ''}`}>
                                            {absensi.pulang ? waktu(absensi.pulang) : null}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 text-center`}>
                                            {absensi.masuk || absensi.pulang ? '1' : '0'}
                                        </td>
                                        <td className={`py-2 px-2 font-medium text-slate-600 text-center`}>
                                            {absensi.masuk && absensi.pulang && (!isTerlambat || !isAwal) ? '1' : '0'}
                                        </td>
                                    </tr>
                                )
                            })}

                    </tbody>
                </table>
            </div>

        </>
    )
}

RekapAbsensiGuruKaryawan.layout = page => <AppLayout children={page} />
export default RekapAbsensiGuruKaryawan