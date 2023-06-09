import DetailLink from '@/Components/Sia/DetailLink'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import getDataBimbingan from '@/Functions/getDataBimbingan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const DataBimbingan = ({ initTahun }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        listBimbingan: []
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getDataBimbingan(data.tahun)
        setData({
            ...data,
            listBimbingan: response.listBimbingan,
        })
    }

    useEffect(() => {

        if (data.tahun)
            trackPromise(getData())

    }, [data.tahun])

    return (
        <>
            <Head title='Data Bimbingan' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">
                data bimbingan dan konseling
            </div>
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
                                NO
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                TANGGAL
                            </th>
                            <th scope='col' className="py-3 px-2">
                                PERMASALAHAN
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                PENYELESAIAN
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                TINDAK LANJUT
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listBimbingan && data.listBimbingan.map((bimbingan, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {hariTanggal(bimbingan.tanggal)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {bimbingan.permasalahan}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {bimbingan.penyelesaian}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {bimbingan.tindak_lanjut}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <DetailLink href={route('data-bimbingan.detail', { id: bimbingan.id })} label='detail' />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

DataBimbingan.layout = page => <AppLayout children={page} />
export default DataBimbingan