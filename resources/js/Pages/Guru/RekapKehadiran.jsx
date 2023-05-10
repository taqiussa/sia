import Jam from '@/Components/Sia/Jam'
import Tanggal from '@/Components/Sia/Tanggal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, Link, router, useForm } from '@inertiajs/react'
import moment from 'moment/moment'
import React, { useEffect } from 'react'

const RekapKehadiran = ({ listAbsensi }) => {

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
                    <div className="flex items-center p-4 bg-white rounded-lg shadow-xs border border-blue-500 shadow-md shadow-blue-500 ">
                        <div className="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total hadir
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                19238
                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                &nbsp;
                            </p>
                        </div>
                    </div>
                    <Link 
                    
                    className="flex group items-center p-4 bg-white rounded-lg shadow-xs border border-yellow-500 shadow-md shadow-yellow-500 cursor-pointer hover:bg-yellow-100 focus:bg-yellow-100 active:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-100 focus:ring-offset-2 transition ease-in-out duration-150">
                        <div className="p-3 mr-4 text-yellow-500 bg-yellow-100 group-hover:bg-yellow-200 rounded-full">
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                Total Users
                            </p>
                            <p className="text-lg font-semibold text-gray-700">
                                19238
                            </p>
                            <p className="mb-2 text-sm font-medium text-gray-600">
                                &nbsp;
                            </p>
                        </div>
                    </Link>
                </div>
            </div>


        </>
    )
}

RekapKehadiran.layout = page => <AppLayout children={page} />
export default RekapKehadiran