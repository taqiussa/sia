import Tahun from '@/Components/Sia/Tahun'
import { penjumlahan, rupiah } from '@/Functions/functions'
import getAdministrasi from '@/Functions/getAdministrasi'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const Administrasi = ({ initTahun, }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        listData: [],
        wajibBayar: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getAdministrasi(data.tahun)
        setData({
            ...data,
            listData: response.listData,
            wajibBayar: response.wajibBayar
        })
    }

    useEffect(() => {

        if (data.tahun)
            trackPromise(getData())

    }, [data.tahun])
    return (
        <>
            <Head title='Administrasi' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">data administrasi siswa</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />
            </div>

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
                        {data.listData && data.listData.map((data, index) => (
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
                                {rupiah(penjumlahan(data.listData, 'jumlah'))}
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-blue-600 font-bold">
                                WAJIB BAYAR
                            </td>
                            <td className="py-2 px-2 font-bold text-blue-600">
                                {rupiah(data.wajibBayar)}
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-red-600 font-bold">
                                KURANG BAYAR
                            </td>
                            <td className="py-2 px-2 font-bold text-red-600">
                                {rupiah(data.wajibBayar - penjumlahan(data.listData, 'jumlah'))}
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