import PrimaryButton from '@/Components/PrimaryButton'
import Jam from '@/Components/Sia/Jam'
import Kehadiran from '@/Components/Sia/Kehadiran'
import Tanggal from '@/Components/Sia/Tanggal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, Link, router, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { toast } from 'react-toastify'

const RekapKehadiranDetail = ({ initTanggal, initJam, initKehadiranId, listKehadiran, listAbsensi, sudahSkorAlpha, sudahSkorBolos }) => {

    const { data, setData, post, processing } = useForm({
        tanggal: initTanggal,
        jam: initJam,
        kehadiranId: initKehadiranId
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submitAlpha = (e, nis) => {
        e.preventDefault()

        post(route('rekap-kehadiran.simpan', {
            nis: nis,
            tanggal: data.tanggal,
            jam: data.jam,
            kehadiranId: data.kehadiranId,
            skorId: 58
        }),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Skor')
                    setData({
                        tanggal: data.tanggal,
                        jam: data.jam,
                        kehadiranId: data.kehadiranId
                    })
                }
            })
    }

    const submitBolos = (e, nis) => {
        e.preventDefault()

        post(route('rekap-kehadiran.simpan', {
            nis: nis,
            tanggal: data.tanggal,
            jam: data.jam,
            kehadiranId: data.kehadiranId,
            skorId: 47
        }),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Skor')
                    setData({
                        tanggal: data.tanggal,
                        jam: data.jam,
                        kehadiranId: data.kehadiranId
                    })
                }
            })
    }

    useEffect(() => {

        if (data.tanggal && data.jam && data.kehadiranId)
            router.reload({
                only: ['listAbsensi'],
                data: {
                    tanggal: data.tanggal,
                    jam: data.jam,
                    kehadiranId: data.kehadiranId
                },
                replace: true,
                preserveState: true
            })
    }, [data.tanggal, data.jam, data.kehadiranId])
    return (
        <>
            <Head title='Rekap Kehadiran' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-5 bg-emerald-200">detail rekap kehadiran</div>
            <Link
                href={route('rekap-kehadiran')}
                children='Kembali'
                className='px-2 py-2 border rounded-md bg-emerald-200 text-slate-600 border-emerald-300 hover:bg-emerald-100 focus:bg-emerald-100 active:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:ring-offset-2 transition ease-in-out duration-150'
            />
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 mt-5 mb-10'>
                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    handleChange={onHandleChange}
                />

                <Jam
                    id='jam'
                    name='jam'
                    value={data.jam}
                    handleChange={onHandleChange}
                />

                <Kehadiran
                    id='kehadiranId'
                    name='kehadiranId'
                    label='kehadiran'
                    value={data.kehadiranId}
                    listKehadiran={listKehadiran.filter(hadir => hadir.id !== 1)}
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
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kehadiran
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listAbsensi && listAbsensi.map((absensi, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {absensi.siswa?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {absensi.kehadiran?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {absensi.kehadiran_id === 4 && !sudahSkorAlpha.some(user => user.nis === absensi.nis) &&
                                        <PrimaryButton
                                            children='Skor Alpha'
                                            onClick={(e) => submitAlpha(e, absensi.nis)}
                                            disabled={processing} />
                                    }
                                    {absensi.kehadiran_id === 5 && !sudahSkorBolos.some(user => user.nis === absensi.nis) &&
                                        <PrimaryButton
                                            children='Skor Bolos'
                                            onClick={(e) => submitBolos(e, absensi.nis)}
                                            disabled={processing} />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

RekapKehadiranDetail.layout = page => <AppLayout children={page} />
export default RekapKehadiranDetail