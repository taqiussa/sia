import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import Tingkat from '@/Components/Sia/Tingkat'
import getKdPerTingkat from '@/Functions/getKdPerTingkat'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const CekKd = ({ initTahun, initSemester }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        semester: initSemester,
        tingkat: '',
        listKd: [],
        listMapel: []
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataKd() {
        const res = await getKdPerTingkat(data.tahun, data.semester, data.tingkat)
        setData({
            ...data,
            listKd: res.listKd,
            listMapel: res.listMapel
        })
    }

    useEffect(() => {
        if (data.tahun && data.semester && data.tingkat)
            trackPromise(
                getDataKd())
    }, [data.tahun, data.semester, data.tingkat])

    return (
        <>
            <Head title='Cek Kd' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">cek KD/TP</div>
            <div className="lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3 mb-3">
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Semester
                    name='semester'
                    value={data.semester}
                    handleChange={onHandleChange}
                />

                <Tingkat
                    name='tingkat'
                    value={data.tingkat}
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
                                Mata Pelajaran
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                KD / TP
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listMapel && data.listMapel.map((mapel, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {mapel.mapel?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <ul>
                                        {data.listKd && data.listKd
                                            .filter(kd => kd.mata_pelajaran_id == mapel.mata_pelajaran_id)
                                            .map(kd => (
                                                <li key={kd.id}>
                                                    {kd.jenis?.nama} : {kd.deskripsi} ({kd.deskripsi.length} Karakter)
                                                </li>
                                            ))
                                        }
                                    </ul>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

CekKd.layout = page => <AppLayout children={page} />
export default CekKd