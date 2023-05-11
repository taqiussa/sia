import Jam from '@/Components/Sia/Jam'
import Tanggal from '@/Components/Sia/Tanggal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, Link, router, useForm } from '@inertiajs/react'
import moment from 'moment/moment'
import React, { useEffect } from 'react'

const RekapKehadiran = ({ listAbsensi, totalSiswa }) => {

    const { data, setData } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        jam: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {
        if (data.tanggal && data.jam)
            router.reload({
                only: ['listAbsensi'],
                data: {
                    tanggal: data.tanggal,
                    jam: data.jam
                },
                replace: true,
                preserveState: true
            })
    }, [data.tanggal, data.jam])


    return (
        <>
            <Head title='Rekap Kehadiran' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap kehadiran</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 mb-10'>
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
            </div>

            <div className="container mx-auto grid">
                <div className="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <div className="flex items-center p-4 bg-white rounded-lg shadow-xs border border-yellow-500 shadow-md shadow-yellow-500 ">
                        <div className="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Hadir
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.filter(absensi => absensi.kehadiran_id == 1).length}

                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                &nbsp;
                            </p>
                        </div>
                    </div>
                    <Link
                        href={route('rekap-kehadiran.detail', {
                            tanggal: data.tanggal,
                            jam: data.jam,
                            kehadiranId: 3
                        })}
                        className="flex group items-center p-4 bg-white rounded-lg shadow-xs border border-yellow-500 shadow-md shadow-yellow-500  hover:bg-yellow-100 focus:bg-yellow-100 active:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-100 focus:ring-offset-2 transition ease-in-out duration-150">
                        <div className="p-3 mr-4 text-yellow-500 bg-yellow-100 group-hover:bg-yellow-200 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Izin
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.filter(absensi => absensi.kehadiran_id == 3).length}
                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Detail
                            </p>
                        </div>
                    </Link>
                    <Link
                        href={route('rekap-kehadiran.detail', {
                            tanggal: data.tanggal,
                            jam: data.jam,
                            kehadiranId: 2
                        })}
                        className="flex group items-center p-4 bg-white rounded-lg shadow-xs border border-amber-500 shadow-md shadow-amber-500  hover:bg-amber-100 focus:bg-amber-100 active:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-100 focus:ring-offset-2 transition ease-in-out duration-150">
                        <div className="p-3 mr-4 text-amber-500 bg-amber-100 group-hover:bg-amber-200 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Sakit
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.filter(absensi => absensi.kehadiran_id == 2).length}

                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Detail
                            </p>
                        </div>
                    </Link>
                    <Link
                        href={route('rekap-kehadiran.detail', {
                            tanggal: data.tanggal,
                            jam: data.jam,
                            kehadiranId: 4
                        })}
                        className="flex group items-center p-4 bg-white rounded-lg shadow-xs border border-rose-500 shadow-md shadow-rose-500  hover:bg-rose-100 focus:bg-rose-100 active:bg-rose-200 focus:outline-none focus:ring-2 focus:ring-rose-100 focus:ring-offset-2 transition ease-in-out duration-150">
                        <div className="p-3 mr-4 text-rose-500 bg-rose-100 group-hover:bg-rose-200 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Alpha
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.filter(absensi => absensi.kehadiran_id == 4).length}

                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Detail
                            </p>
                        </div>
                    </Link>
                    <Link
                        href={route('rekap-kehadiran.detail', {
                            tanggal: data.tanggal,
                            jam: data.jam,
                            kehadiranId: 5
                        })}
                        className="flex group items-center p-4 bg-white rounded-lg shadow-xs border border-red-500 shadow-md shadow-red-500  hover:bg-red-100 focus:bg-red-100 active:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-100 focus:ring-offset-2 transition ease-in-out duration-150">
                        <div className="p-3 mr-4 text-red-500 bg-red-100 group-hover:bg-red-200 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Bolos
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.filter(absensi => absensi.kehadiran_id == 5).length}

                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Detail
                            </p>
                        </div>
                    </Link>
                    <Link
                        href={route('rekap-kehadiran.detail', {
                            tanggal: data.tanggal,
                            jam: data.jam,
                            kehadiranId: 6
                        })}
                        className="flex group items-center p-4 bg-white rounded-lg shadow-xs border border-sky-500 shadow-md shadow-sky-500  hover:bg-sky-100 focus:bg-sky-100 active:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-100 focus:ring-offset-2 transition ease-in-out duration-150">
                        <div className="p-3 mr-4 text-sky-500 bg-sky-100 group-hover:bg-sky-200 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Pulang
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.filter(absensi => absensi.kehadiran_id == 6).length}

                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Detail
                            </p>
                        </div>
                    </Link>
                    <div

                        className="flex  items-center p-4 bg-white rounded-lg shadow-xs border border-blue-500 shadow-md shadow-blue-500 ">
                        <div className="p-3 mr-4 text-blue-500 bg-blue-100  rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Siswa
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {totalSiswa}
                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                &nbsp;
                            </p>
                        </div>
                    </div>
                    <div

                        className="flex items-center p-4 bg-white rounded-lg shadow-xs border border-indigo-500 shadow-md shadow-indigo-500">
                        <div className="p-3 mr-4 text-indigo-500 bg-indigo-100  rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Absensi
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                {listAbsensi.length}
                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                &nbsp;
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </>
    )
}

RekapKehadiran.layout = page => <AppLayout children={page} />
export default RekapKehadiran