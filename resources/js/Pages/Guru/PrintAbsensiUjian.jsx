import Jam from '@/Components/Sia/Jam'
import JenisKelaminSemua from '@/Components/Sia/JenisKelaminSemua'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import Ujian from '@/Components/Sia/Ujian'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'

const PrintAbsensiUjian = ({ initTahun, initSemester, listMapel }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        semester: initSemester,
        namaUjian: '',
        jenisKelamin: '',
        jam: '',
        mataPelajaranId: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    return (
        <>
            <Head title='Print Absensi Ujian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">print absensi ujian</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    message={errors.tanggal}
                    handleChange={onHandleChange}
                />

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

                <Ujian
                    id="namaUjian"
                    name="namaUjian"
                    value={data.namaUjian}
                    message={errors.namaUjian}
                    handleChange={onHandleChange}
                />

                <Jam
                    id='jam'
                    name='jam'
                    value={data.jam}
                    message={errors.jam}
                    handleChange={onHandleChange}
                />

                <MataPelajaran
                    id='mataPelajaranId'
                    name='mataPelajaranId'
                    value={data.mataPelajaranId}
                    message={errors.mataPelajaranId}
                    handleChange={onHandleChange}
                    listMapel={listMapel}
                />

                <JenisKelaminSemua
                    id='jenisKelamin'
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
                />


                <div className="flex justify-start items-end">
                    <PrintLink href={route('print-absensi-ujian.print', {
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        semester: data.semester,
                        namaUjian: data.namaUjian,
                        jam: data.jam,
                        jenisKelamin: data.jenisKelamin,
                        mataPelajaranId: data.mataPelajaranId
                    })} label='print' />
                </div>
            </div>
        </>
    )
}

PrintAbsensiUjian.layout = page => <AppLayout children={page} />
export default PrintAbsensiUjian