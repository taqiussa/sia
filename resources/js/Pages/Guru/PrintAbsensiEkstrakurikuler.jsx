import DownloadLinkPdf from '@/Components/Sia/DownloadLinkPdf'
import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import getAbsensiEkstrakurikuler from '@/Functions/getAbsensiEkstrakurikuler'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const PrintAbsensiEkstrakurikuler = ({ initTahun, listEkstrakurikuler }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        ekstrakurikulerId: '',
        jenisKelamin: '',
        listSiswa: []
    })

    async function getDataSiswa() {
        const response = await getAbsensiEkstrakurikuler(data.tanggal, data.tahun, data.ekstrakurikulerId, data.jenisKelamin)
        setData({ ...data, listSiswa: response.listSiswa })
    }
    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tanggal && data.tahun && data.ekstrakurikulerId && data.jenisKelamin)
            trackPromise(getDataSiswa())

    }, [data.tanggal, data.tahun, data.ekstrakurikulerId, data.jenisKelamin])

    return (
        <>
            <Head title='Print Absensi Ekstrakurikuler' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">print absensi ekstrakurikuler</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>

                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    handleChange={onHandleChange}
                />

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Ekstrakurikuler
                    id='ekstrakurikulerId'
                    name='ekstrakurikulerId'
                    value={data.ekstrakurikulerId}
                    handleChange={onHandleChange}
                    listEkstrakurikuler={listEkstrakurikuler}
                />

                <JenisKelamin
                    id='jenisKelamin'
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    handleChange={onHandleChange}
                />

                <div className="flex items-end">
                    {
                        data.tahun && data.tanggal && data.ekstrakurikulerId && data.jenisKelamin &&
                        <DownloadLinkPdf
                            href={route('print-absensi-ekstrakurikuler.download', {
                                tahun: data.tahun,
                                tanggal: data.tanggal,
                                ekstrakurikulerId: data.ekstrakurikulerId,
                                jenisKelamin: data.jenisKelamin
                            })}
                            label='download' />

                    }
                </div>
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
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kehadiran
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Guru
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
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.absensi?.kehadiran?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.absensi.guru?.name}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

PrintAbsensiEkstrakurikuler.layout = page => <AppLayout children={page} />
export default PrintAbsensiEkstrakurikuler