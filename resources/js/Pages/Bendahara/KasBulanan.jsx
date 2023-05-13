import Bulan from '@/Components/Sia/Bulan'
import PrintLink from '@/Components/Sia/PrintLink'
import Tahun from '@/Components/Sia/Tahun'
import { namaBulan, penjumlahan, rupiah } from '@/Functions/functions'
import getKasBulanan from '@/Functions/getKasBulanan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const KasBulanan = ({ initTahun }) => {

    const { data, setData, errors, processing } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM'),
        bulanLalu: '',
        listPemasukan: [],
        listPengeluaran: [],
        saldo: 0,
        saldoLalu: 0,
        totalSPP: 0,
        totalPemasukan: 0,
        totalPengeluaran: 0,
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getKasBulanan(data.tahun, data.bulan)
        setData({
            tahun: data.tahun,
            bulan: data.bulan,
            bulanLalu: response.bulanLalu,
            listPemasukan: response.listPemasukan,
            listPengeluaran: response.listPengeluaran,
            saldo: response.saldo,
            saldoLalu: response.saldoLalu,
            totalSPP: response.totalSPP,
            totalPemasukan: response.totalPemasukan,
            totalPengeluaran: response.totalPengeluaran,
        })

    }
    useEffect(() => {

        if (data.tahun && data.bulan) {
            trackPromise(getData())
        }

    }, [data.tahun, data.bulan])
    return (
        <>
            <Head title='Kas Bulanan' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">kas bulanan</div>

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

                <div className="flex items-end space-x-2">
                    <PrintLink
                        href={route('kas-bulanan-print', {
                            tahun: data.tahun,
                            bulan: data.bulan
                        })}
                        label='print'
                    />
                </div>
            </div>
            <div className='lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 space-y-2 py-5'>
                <div className='overflow-x-auto space-y-7'>
                    <table className="w-full text-sm text-slate-600">
                        <thead className="text-sm text-slate-600 bg-gray-50">
                            <tr>
                                <th scope='col' className="py-3 px-2">
                                    No
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Kategori Pemasukan
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    1
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    PEMBAYARAN SPP SISWA
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {rupiah(data.totalSPP)}
                                </td>
                            </tr>
                            {data.listPemasukan &&
                                data.listPemasukan.map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 2}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(penjumlahan(list.pemasukan, 'jumlah'))}
                                        </td>
                                    </tr>
                                ))}
                            <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300" colSpan={2}>
                                    Total
                                </td>
                                <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                    {rupiah(data.totalPemasukan)}
                                </td>
                            </tr>
                            <tr>
                                <td colSpan={3}>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colSpan={3}>&nbsp;</td>
                            </tr>
                            <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300 capitalize" colSpan={2}>
                                    saldo akhir bulan {namaBulan(data.bulanLalu)} tahun {data.tahun}
                                </td>
                                <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                    {rupiah(data.saldoLalu)}
                                </td>
                            </tr>
                            <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300 capitalize" colSpan={2}>
                                    total pemasukan {namaBulan(data.bulan)} tahun {data.tahun}
                                </td>
                                <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                    {rupiah(data.totalPemasukan)}
                                </td>
                            </tr>
                            <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300 capitalize" colSpan={2}>
                                    total pengeluaran {namaBulan(data.bulan)} tahun {data.tahun}
                                </td>
                                <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                    {rupiah(data.totalPengeluaran)}
                                </td>
                            </tr>
                            <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300 capitalize" colSpan={2}>
                                    saldo akhir {namaBulan(data.bulan)} tahun {data.tahun}
                                </td>
                                <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                    {rupiah(data.saldo)}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div className='overflow-x-auto'>
                    <table className="w-full text-sm text-slate-600">
                        <thead className="text-sm text-slate-600 bg-gray-50">
                            <tr>
                                <th scope='col' className="py-3 px-2">
                                    No
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Kategori Pengeluaran
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {data.listPengeluaran &&
                                data.listPengeluaran.map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(penjumlahan(list.pengeluaran, 'jumlah'))}
                                        </td>
                                    </tr>
                                ))}
                            <tr>
                                <td className="py-2 px-2 font-bold text-xl text-slate-600 bg-slate-300" colSpan={2}>
                                    Total
                                </td>
                                <td className="py-2 px-2 font-bold text-xl text-slate-600 bg-slate-300">
                                    {rupiah(data.totalPengeluaran)}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    )
}

KasBulanan.layout = page => <AppLayout children={page} />
export default KasBulanan