import Bulan from '@/Components/Sia/Bulan'
import JenisIbadah from '@/Components/Sia/JenisIbadah'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kategori from '@/Components/Sia/Kategori'
import Tahun from '@/Components/Sia/Tahun'
import { arrayJenisIbadah, arrayKategoriRole, namaKehadiran } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'

const RekapIbadah = ({ initTahun, listUser }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        bulan: '',
        jenisIbadah: '',
        kategori: '',
        jenisKelamin: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }
    useEffect(() => {
        if (data.tahun
            && data.bulan
            && data.kategori
            && data.jenisIbadah
            && data.jenisKelamin
        ) {
            router.reload({
                only: ['listUser'],
                data: {
                    tahun: data.tahun,
                    bulan: data.bulan,
                    kategori: data.kategori,
                    jenisIbadah: data.jenisIbadah,
                    jenisKelamin: data.jenisKelamin
                }
            })
        }
    }, [data.tahun, data.bulan, data.jenisIbadah, data.kategori, data.jenisKelamin])

    return (
        <>
            <Head title='Rekap Ibadah' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap ibadah</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    name='bulan'
                    value={data.bulan}
                    handleChange={onHandleChange}
                />

                <Kategori
                    name='kategori'
                    value={data.kategori}
                    handleChange={onHandleChange}
                    listKategori={arrayKategoriRole()}
                />

                <JenisIbadah
                    name='jenisIbadah'
                    value={data.jenisIbadah}
                    handleChange={onHandleChange}
                    listJenis={arrayJenisIbadah()}
                />

                <JenisKelamin
                    name="jenisKelamin"
                    value={data.jenisKelamin}
                    handleChange={onHandleChange}
                />

            </div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th rowSpan={2} scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th rowSpan={2} scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th colSpan={5} scope='col' className="py-3 px-2">
                                Kehadiran
                            </th>
                        </tr>
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                M-1
                            </th>
                            <th scope='col' className="py-3 px-2">
                                M-2
                            </th>
                            <th scope='col' className="py-3 px-2">
                                M-3
                            </th>
                            <th scope='col' className="py-3 px-2">
                                M-4
                            </th>
                            <th scope='col' className="py-3 px-2">
                                M-5
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listUser && listUser.map((user, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {user.ibadah_details && user.ibadah_details
                                        .filter(detail => detail.minggu == 1)
                                        .map(detail => namaKehadiran(detail.kehadiran_id))
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {user.ibadah_details && user.ibadah_details
                                        .filter(detail => detail.minggu == 2)
                                        .map(detail => namaKehadiran(detail.kehadiran_id))
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {user.ibadah_details && user.ibadah_details
                                        .filter(detail => detail.minggu == 3)
                                        .map(detail => namaKehadiran(detail.kehadiran_id))
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {user.ibadah_details && user.ibadah_details
                                        .filter(detail => detail.minggu == 4)
                                        .map(detail => namaKehadiran(detail.kehadiran_id))
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {user.ibadah_details && user.ibadah_details
                                        .filter(detail => detail.minggu == 5)
                                        .map(detail => namaKehadiran(detail.kehadiran_id))
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

RekapIbadah.layout = page => <AppLayout children={page} />
export default RekapIbadah