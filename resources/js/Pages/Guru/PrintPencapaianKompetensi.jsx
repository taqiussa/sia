import KategoriNilai from '@/Components/Sia/KategoriNilai'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const PrintPencapaianKompetensi = ({ initTahun, initSemester, listMapel, listKelas, listKategori }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            router.reload({
                only: ['listKelas'],
                data: {
                    tahun: data.tahun,
                    mataPelajaranId: data.mataPelajaranId
                }
            })
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.tahun && data.kelasId)
            router.reload({
                only: ['listKategori'],
                data: {
                    tahun: data.tahun,
                    kelasId: data.kelasId
                }
            })
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Print Pencapaian Kompetensi' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">print pencapaian kompetensi</div>
            <div className="lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 space-y-2 mb-2">

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

                <MataPelajaran
                    id='mataPelajaranId'
                    name='mataPelajaranId'
                    value={data.mataPelajaranId}
                    handleChange={onHandleChange}
                    listMapel={listMapel}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                />

                <KategoriNilai
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />
            </div>

            <PrintLink
                href={route('print-pencapaian-kompetensi.print', {
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId,
                    kelasId: data.kelasId,
                    kategoriNilaiId: data.kategoriNilaiId
                })}
                label='print'
            />
        </>

    )
}

PrintPencapaianKompetensi.layout = page => <AppLayout children={page} />
export default PrintPencapaianKompetensi