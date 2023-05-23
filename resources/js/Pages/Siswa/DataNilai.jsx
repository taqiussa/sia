import DetailLink from '@/Components/Sia/DetailLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import getDataBimbingan from '@/Functions/getDataBimbingan'
import getDataNilai from '@/Functions/getDataNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const DataNilai = ({ initTahun, initSemester }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        semester: initSemester,
        listJenis: [],
        listMapel: [],
        listPenilaian: []
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getDataNilai(data.tahun, data.semester)
        setData({
            ...data,
            listJenis: response.listJenis,
            listMapel: response.listMapel,
            listPenilaian: response.listPenilaian
        })
    }

    useEffect(() => {

        if (data.tahun && data.semester)
            trackPromise(getData())

    }, [data.tahun, data.semester])

    return (
        <>
            <Head title='Data Bimbingan' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">
                data nilai
            </div>
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
            </div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2 text-left">
                                NO
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                MATA PELAJARAN
                            </th>
                            {data.listJenis && data.listJenis.map((jenis, index) => (
                                <th key={index} scope='col' className="py-3 px-2">
                                    {jenis.nama}
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {data.listMapel && data.listMapel.map((mapel, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {mapel.mapel?.nama}
                                </td>
                                {data.listJenis && data.listJenis.map((jenis, index) => (
                                    <td key={index} className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {data.listPenilaian && data.listPenilaian.filter(nilai => nilai.jenis_penilaian_id == jenis.id && nilai.mata_pelajaran_id == mapel.mata_pelajaran_id)
                                            .map(nilai => nilai.nilai)
                                        }
                                    </td>
                                ))}
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

DataNilai.layout = page => <AppLayout children={page} />
export default DataNilai