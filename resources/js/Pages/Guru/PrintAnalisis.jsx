import DownloadLinkPdf from '@/Components/Sia/DownloadLinkPdf'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'

const PrintAnalisis = ({ initTahun, initSemester, listMapel, listKelas, listKategori, listJenis }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: ''
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
                },
                replace: true,
                preserveState: true
            })

    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {
        if (data.tahun && data.kelasId)
            router.reload({
                only: ['listKategori'],
                data: {
                    tahun: data.tahun,
                    kelasId: data.kelasId
                },
                replace: true,
                preserveState: true
            })
    }, [data.tahun, data.kelasId])

    useEffect(() => {
        if (data.kategoriNilaiId) {

            setData('jenisPenilaianId', '')
            router.reload({
                only: ['listJenis'],
                data: {
                    tahun: data.tahun,
                    semester: data.semester,
                    kategoriNilaiId: data.kategoriNilaiId
                },
                replace: true,
                preserveState: true
            })
        }
    }, [data.semester, data.kategoriNilaiId])

    return (
        <>
            <Head title='Print Analisis' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">print analisis</div>
            <div className="lg:grid lg:grid-cols-3 lg:gap-2 grid grid-cols-2 gap-2 lg:space-y-0 space-y-2 mb-2">
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

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={listJenis}
                />

            </div>
            <PrintLink href={route('print-analisis.print', {
                tahun: data.tahun,
                semester: data.semester,
                mataPelajaranId: data.mataPelajaranId,
                kelasId: data.kelasId,
                kategoriNilaiId: data.kategoriNilaiId,
                jenisPenilaianId: data.jenisPenilaianId
            })}
                label='print'
            />
        </>
    )
}

PrintAnalisis.layout = page => <AppLayout children={page} />
export default PrintAnalisis