import Hari from '@/Components/Sia/Hari'
import Jam from '@/Components/Sia/Jam'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import { namaHari } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const RekapJamKosong = ({ initTahun, initSemester, listJamKosong }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        semester: initSemester,
        hari: '',
        jam: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {
        if (
            data.tahun
            && data.semester
            && data.hari
            && data.jam
        )
            router.reload({
                only: ['listJamKosong'],
                data: {
                    tahun: data.tahun,
                    semester: data.semester,
                    hari: data.hari,
                    jam: data.jam
                }
            })
    }, [data.tahun, data.semester, data.hari, data.jam])
    return (
        <>
            <Head title='Rekap Jam Kosong' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">rekap jam kosong guru</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Semester
                    id='semester'
                    name='semester'
                    value={data.semester}
                    handleChange={onHandleChange}
                />

                <Hari
                    id='hari'
                    name='hari'
                    value={data.hari}
                    handleChange={onHandleChange}
                />

                <Jam
                    id='jam'
                    name='jam'
                    value={data.jam}
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
                                Hari
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listJamKosong && listJamKosong.map((kosong, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kosong.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {namaHari(kosong.hari)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kosong.jam}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

RekapJamKosong.layout = page => <AppLayout children={page} />
export default RekapJamKosong