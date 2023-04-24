import DownloadLinkPdf from '@/Components/Sia/DownloadLinkPdf'
import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'

const PrintAbsensiEkstrakurikuler = ({ initTahun, listEkstrakurikuler, listSiswa }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        ekstrakurikulerId: '',
        jenisKelamin: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tanggal && data.tahun && data.ekstrakurikulerId && data.jenisKelamin)
            router.reload({
                only: ['listSiswa'],
                data: {
                    tahun: data.tahun,
                    tanggal: data.tanggal,
                    ekstrakurikulerId: data.ekstrakurikulerId,
                    jenisKelamin: data.jenisKelamin
                },
                preserveState: true,
                replace: true
            })

    }, [data.tanggal, data.tahun, data.ekstrakurikulerId, data.jenisKelamin])

    return (
        <>
            <Head title='Print Absensi Ekstrakurikuler' />
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
                        {listSiswa && listSiswa.map((siswa, index) => (
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