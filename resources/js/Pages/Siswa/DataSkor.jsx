import DetailLink from '@/Components/Sia/DetailLink'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, penjumlahan } from '@/Functions/functions'
import getDataBimbingan from '@/Functions/getDataBimbingan'
import getDataSkor from '@/Functions/getDataSkor'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const DataSkor = ({ initTahun }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        listSkor: []
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getDataSkor(data.tahun)
        setData({
            ...data,
            listSkor: response.listSkor,
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
                data skor
            </div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />
            </div>
            <div className="py-3 px-1 font-bold text-lg text-slate-600">
                Saldo Skor : {penjumlahan(data.listSkor, 'skor')}
            </div>
            <div className="overflow-x-auto">
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
                                KETERANGAN
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                SKOR
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                GURU
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listSkor && data.listSkor.map((skor, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {hariTanggal(skor.tanggal)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {skor.skors?.keterangan}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {skor.skor}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {skor.user?.name}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

DataSkor.layout = page => <AppLayout children={page} />
export default DataSkor