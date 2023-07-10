import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import Header from '@/Layouts/Partials/Header'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const RaporTendik = ({ initTahun, penilaian, cekWaliKelas, penilaianWaliKelas, avgGuru, avgWali }) => {

    const { data, setData, errors, processing } = useForm({
        tahun: initTahun
    })

    useEffect(() => {
        if (data.tahun) {
            router.reload({
                only: ['penilaian', 'cekWaliKelas', 'penilaianWaliKelas', 'avgGuru', 'avgWali'],
                data: {
                    tahun: data.tahun
                },
                preserveScroll: true,
                preserveState: true,
                replace: true
            })
        }
    }, [data.tahun])

    return (
        <>
            <Head title='Rapor Tendik' />
            <Header title='rapor tendik' />
            <div className="lg:grid lg:grid-cols-4">
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    handleChange={(e) => setData('tahun', e.target.value)}
                />
            </div>
            <div className="font-bold text-slate-600 text-lg px-2 capitalize mx-4 my-4">
                rapor guru dan karyawan
            </div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jenis Penilaian
                            </th>
                            <th scope='col' className="py-3 px-2">
                                Nilai
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {penilaian && penilaian.map((user, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {user.jenis?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {user.penilaian?.nilai}
                                </td>
                            </tr>
                        ))}
                        <tr className="bg-gray-300">
                            <td colSpan={2} className="py-2 px-2 text-slate-600 text-center font-bold">
                                Rata - rata
                            </td>
                            <td className="py-2 px-2 font-bold text-slate-600 text-center">
                                {avgGuru}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {cekWaliKelas > 0 &&
                <>
                    <div className="font-bold text-slate-600 text-lg px-2 capitalize mx-4 my-4">
                        rapor wali kelas
                    </div>
                    <div className="overflow-x-auto pt-2">
                        <table className="w-full text-sm text-slate-600">
                            <thead className="text-sm text-slate-600 bg-gray-50">
                                <tr>
                                    <th scope='col' className="py-3 px-2">
                                        No
                                    </th>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Jenis Penilaian
                                    </th>
                                    <th scope='col' className="py-3 px-2">
                                        Nilai
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {penilaianWaliKelas && penilaianWaliKelas.map((user, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {user.jenis?.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {user.penilaian?.nilai}
                                        </td>
                                    </tr>
                                ))}
                                <tr className="bg-gray-300">
                                    <td colSpan={2} className="py-2 px-2 text-slate-600 text-center font-bold">
                                        Rata - rata
                                    </td>
                                    <td className="py-2 px-2 font-bold text-slate-600 text-center">
                                        {avgWali}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </>
            }
        </>
    )
}

RaporTendik.layout = page => <AppLayout children={page} />
export default RaporTendik