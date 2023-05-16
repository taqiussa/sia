import { hariTanggal } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head } from '@inertiajs/react'
import React from 'react'

const AlquranBinnadzor = ({ listJenis, listNilai }) => {
    return (
        <>
            <Head title="Al Qur'an Bil Ghoib" />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-slate-600 text-lg uppercase mb-2">penilaian al qur'an binnadzor</div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2 text-left">
                                NO
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                JUZ
                            </th>
                            <th scope='col' className="py-3 px-2">
                                NILAI
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                GURU
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                TANGGAL
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listJenis && listJenis.map((jenis, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {jenis.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {listNilai && listNilai.filter(nilai => nilai.jenis_alquran_id == jenis.id)
                                        .map(hasil => hasil.nilai)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {listNilai && listNilai.filter(nilai => nilai.jenis_alquran_id == jenis.id)
                                        .map(hasil => hasil.user?.name)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {listNilai && listNilai.filter(nilai => nilai.jenis_alquran_id == jenis.id)
                                        .map(hasil => hariTanggal(hasil.tanggal))}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

AlquranBinnadzor.layout = page => <AppLayout children={page} />
export default AlquranBinnadzor