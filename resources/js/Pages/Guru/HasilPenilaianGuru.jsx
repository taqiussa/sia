import JenisKelamin from '@/Components/Sia/JenisKelamin'
import KategoriNilaiKaryawan from '@/Components/Sia/KategoriNilaiKaryawan'
import PrintLink from '@/Components/Sia/PrintLink'
import Tahun from '@/Components/Sia/Tahun'
import { penjumlahan } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import Header from '@/Layouts/Partials/Header'
import { Head, router, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'

const HasilPenilaianGuru = ({ initTahun, listKategori, listJenis, listUser }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        kategoriNilaiId: '',
        jenisKelamin: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.kategoriNilaiId) {
            router.reload({
                only: ['listJenis', 'listUser'],
                data: {
                    tahun: data.tahun,
                    kategoriNilaiId: data.kategoriNilaiId,
                    jenisKelamin: data.jenisKelamin
                },
                preserveState: true,
                replace: true
            })
        }

    }, [data.tahun, data.kategoriNilaiId, data.jenisKelamin])

    return (
        <>
            <Head title='Hasil Penilaian Guru' />
            <Header title='hasil penilaian guru' />
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <KategoriNilaiKaryawan
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />
                {(data.kategoriNilaiId == 3 || data.kategoriNilaiId == 1) &&
                    <JenisKelamin
                        name='jenisKelamin'
                        value={data.jenisKelamin}
                        handleChange={onHandleChange}
                    />
                }
            </div>
            {((data.kategoriNilaiId == 2 &&
                data.tahun) || (data.kategoriNilaiId != 2 && data.tahun && data.jenisKelamin)) &&
                <PrintLink href={route('hasil-penilaian-guru.print', {
                    tahun: data.tahun,
                    kategoriNilaiId: data.kategoriNilaiId,
                    jenisKelamin: data.jenisKelamin
                })}
                    label='print'
                />
            }
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th rowSpan={2} scope='col' className="py-3 px-2">
                                Rank
                            </th>
                            <th rowSpan={2} scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            {
                                listJenis && listJenis.map((jenis, index) =>
                                    <th key={index} scope='col' className="py-3 px-2">
                                        {jenis.jenis?.nama}
                                    </th>
                                )
                            }
                            <th rowSpan={2} scope='col' className="py-3 px-2">
                                Rata-Rata
                            </th>
                        </tr>
                        <tr>
                            {
                                listJenis && listJenis.map((jenis, index) =>
                                    <th key={index} scope='col' className="py-3 px-2">
                                        {jenis.kkm?.kkm}
                                    </th>
                                )
                            }
                        </tr>
                    </thead>
                    <tbody>
                        {listUser && listUser.map((user, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {user.user?.name ?? user.name}
                                </td>
                                {
                                    listJenis && listJenis.map((jenis, index) =>
                                        <td key={index} className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {
                                                user.penilaians &&
                                                user.penilaians
                                                    .filter(nilai => nilai.jenis_penilaian_id == jenis.jenis_penilaian_id)
                                                    .map((nilai, index) =>
                                                        <li className='list-none' key={index}>
                                                            {nilai.nilai}
                                                        </li>
                                                    )
                                            }
                                        </td>
                                    )
                                }
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {Number(user.penilaians_avg_nilai).toFixed(2)}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

HasilPenilaianGuru.layout = page => <AppLayout children={page} />
export default HasilPenilaianGuru