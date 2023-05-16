import { penjumlahan, rupiah } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head } from '@inertiajs/react'
import React from 'react'

const Administrasi = ({ listData, wajibBayar }) => {
    return (
        <>
            <Head title='Administrasi' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">data administrasi siswa</div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2 text-left">
                                PEMBAYARAN
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                JUMLAH
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listData && listData.map((data, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.gunabayar.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {rupiah(data.jumlah)}
                                </td>
                            </tr>
                        ))}
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-emerald-600 font-bold">
                                TOTAL PEMBAYARAN
                            </td>
                            <td className="py-2 px-2 font-bold text-emerald-600">
                                {rupiah(penjumlahan(listData, 'jumlah'))}
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-blue-600 font-bold">
                                WAJIB BAYAR
                            </td>
                            <td className="py-2 px-2 font-bold text-blue-600">
                                {rupiah(wajibBayar)}
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-red-600 font-bold">
                                KURANG BAYAR
                            </td>
                            <td className="py-2 px-2 font-bold text-red-600">
                                {rupiah(wajibBayar - penjumlahan(listData, 'jumlah'))}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </>
    )
}

Administrasi.layout = page => <AppLayout children={page} />
export default Administrasi