import Kelas from '@/Components/Sia/Kelas'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getPenilaianPerKelas from '@/Functions/getPenilaianPerKelas'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const CekPenilaianKelas = ({ initTahun, initSemester, listKelas }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        kelasId: '',
        semester: initSemester,
        listJenis: [],
        listMapel: [],
        listPenilaian: [],
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataPenilaian() {
        const res = await getPenilaianPerKelas(data.tahun, data.semester, data.kelasId)
        setData({
            ...data,
            listJenis: res.listJenis,
            listPenilaian: res.listPenilaian,
            listMapel: res.listMapel
        })
    }

    useEffect(() => {
        if (data.tahun && data.semester && data.kelasId)
            trackPromise(
                getDataPenilaian())
    }, [data.tahun, data.semester, data.kelasId])

    return (
        <>
            <Head title='Cek Penilaian' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">cek penilaian</div>
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

                <Kelas
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
                                Mata Pelajaran
                            </th>
                            {
                                data.listJenis && data.listJenis.map(jenis => (
                                    <th scope='col' className="py-3 px-2 text-left">
                                        {jenis.nama}
                                    </th>
                                ))
                            }
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
                                {
                                    data.listJenis && data.listJenis.map(jenis => (
                                        <td className="py-2 px-2 font-medium text-slate-600" key={jenis.id}>
                                            {
                                                data.listPenilaian && data.listPenilaian.filter(nilai => nilai.mata_pelajaran_id == mapel.mata_pelajaran_id && nilai.jenis_penilaian_id == jenis.id).length
                                            }
                                        </td>
                                    ))
                                }
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

CekPenilaianKelas.layout = page => <AppLayout children={page} />
export default CekPenilaianKelas