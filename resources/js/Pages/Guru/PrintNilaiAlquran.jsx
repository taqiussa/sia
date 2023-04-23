import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import PrintLinkMerah from '@/Components/Sia/PrintLinkMerah'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import { isEmpty } from 'lodash'
import React, { useEffect } from 'react'

const PrintNilaiAlquran = ({ initTahun, listKelas, listSiswa }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        kelasId: '',
        nis: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        router.reload({
            only: ['listKelas', 'listSiswa'],
            data: {
                tahun: data.tahun,
                kelasId: data.kelasId
            },
            replace: true,
            preserveState: true
        })

    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title="Print Nilai Al Qur'an" />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">print nilai al qur'an</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    listKelas={listKelas}
                    handleChange={onHandleChange}
                />

            </div>
            <div className="lg:flex lg:space-x-2 lg:space-y-0 space-y-2">

                {/* <PrintLink href={route('print-nilai-alquran.bilghoib', {
                    tanggalAwal: data.tanggalAwal,
                    tanggalAkhir: data.tanggalAkhir,
                    kelasId: data.kelasId,
                    tahun: data.tahun
                })} label='bilghoib' /> */}

                <PrintLink href={route('print-nilai-alquran.bilghoib-horizontal', {
                    tanggalAwal: data.tanggalAwal,
                    tanggalAkhir: data.tanggalAkhir,
                    kelasId: data.kelasId,
                    tahun: data.tahun
                })} label='bilghoib horizontal' />

                {/* <PrintLinkMerah href={route('print-nilai-alquran.binnadzor', {
                    tanggalAwal: data.tanggalAwal,
                    tanggalAkhir: data.tanggalAkhir,
                    kelasId: data.kelasId,
                    tahun: data.tahun
                })} label='binnadzor' /> */}

                <PrintLinkMerah href={route('print-nilai-alquran.binnadzor-horizontal', {
                    tanggalAwal: data.tanggalAwal,
                    tanggalAkhir: data.tanggalAkhir,
                    kelasId: data.kelasId,
                    tahun: data.tahun
                })} label='binnadzor horizontal' />

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
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className="inline-flex space-x-2">

                                        <PrintLink href={route('print-nilai-alquran.bilghoib-per-siswa', {
                                            tahun: data.tahun,
                                            kelasId: data.kelasId,
                                            nis: siswa.nis
                                        })} label='bilghoib' />

                                        <PrintLinkMerah href={route('print-nilai-alquran.binnadzor-per-siswa', {
                                            tahun: data.tahun,
                                            kelasId: data.kelasId,
                                            nis: siswa.nis
                                        })} label='binnadzor' />
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

PrintNilaiAlquran.layout = page => <AppLayout children={page} />
export default PrintNilaiAlquran