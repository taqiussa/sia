import Kelas from '@/Components/Sia/Kelas'
import Tahun from '@/Components/Sia/Tahun'
import { penjumlahan } from '@/Functions/functions'
import getSiswaWithSkor from '@/Functions/getSiswaWithSkor'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const SaldoSkor = ({ initTahun, listKelas }) => {

    const { data, setData, processing } = useForm({
        tahun: initTahun,
        kelasId: '',
        listSiswa: []
    })

    async function getDataSkor() {
        const response = await getSiswaWithSkor(data.tahun, data.kelasId)
        setData({ ...data, listSiswa: response.listSiswa })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {
        if (data.tahun && data.kelasId)
            trackPromise(getDataSkor())
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Saldo Skor' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 uppercase mb-2">saldo skor</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
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
                            <th scope='col' className="py-3 px-2">
                                Skor Negatif
                            </th>
                            <th scope='col' className="py-3 px-2">
                                Skor Positif
                            </th>
                            <th scope='col' className="py-3 px-2">
                                Saldo Skor
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listSiswa && data.listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {penjumlahan(siswa.penilaian_skors.filter(skor => skor.skor < 0), 'skor')}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {penjumlahan(siswa.penilaian_skors.filter(skor => skor.skor > 0), 'skor')}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {penjumlahan(siswa.penilaian_skors, 'skor')}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

SaldoSkor.layout = page => <AppLayout children={page} />
export default SaldoSkor