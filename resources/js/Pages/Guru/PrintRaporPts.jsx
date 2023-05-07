import DownloadLinkPdf from '@/Components/Sia/DownloadLinkPdf'
import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getDataKelasWaliKelas from '@/Functions/getDataKelasWaliKelas'
import getSiswa from '@/Functions/getSiswa'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const PrintRaporPts = ({ initTahun, initSemester, listKelas }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
    })

    const [listSiswa, setListSiswa] = useState([])

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getDataKelasWaliKelas(data.tahun)
        setData('kelasId', response.kelasId)
    }

    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    useEffect(() => {
        if (data.tahun) {
            trackPromise(
                getData()
            )
        }
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.kelasId
        ) {

            trackPromise(
                getDataSiswa()
            )

        }
        else {
            setListSiswa([])
        }
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Print Rapor PTS' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">print rapor pts</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Semester
                    id='semester'
                    name='semester'
                    value={data.semester}
                    message={errors.semester}
                    handleChange={onHandleChange}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                    disabled={true}
                />
            </div>

            <div className="overflow-x-auto">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                NIS
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.nis}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                    <PrintLink
                                        href={route('print-rapor-pts.download', {
                                            tahun: data.tahun,
                                            semester: data.semester,
                                            kelasId: data.kelasId,
                                            nis: siswa.nis,
                                        })}
                                        label='print'
                                    />

                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

        </>
    )
}

PrintRaporPts.layout = page => <AppLayout children={page} />
export default PrintRaporPts