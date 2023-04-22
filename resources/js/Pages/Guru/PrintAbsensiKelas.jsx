import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'

const PrintAbsensiKelas = ({ initTahun, initSemester, listKelas }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        tanggalAwal: moment(new Date()).format('YYYY-MM-DD'),
        tanggalAkhir: moment(new Date()).format('YYYY-MM-DD'),
        semester: initSemester,
        kelasId: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    return (
        <>
            <Head title='Print Absensi Kelas' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">print absensi kelas</div>
            <div className="py-2 capitalize font-bold text-slate-600">print per bulan</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tanggal
                    id='tanggalAwal'
                    name='tanggalAwal'
                    label='tanggal awal'
                    value={data.tanggalAwal}
                    message={errors.tanggalAwal}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    id='tanggalAkhir'
                    name='tanggalAkhir'
                    label='tanggal akhir'
                    value={data.tanggalAkhir}
                    message={errors.tanggalAkhir}
                    handleChange={onHandleChange}
                />

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

                <div className="flex items-end">
                    <PrintLink href={route('print-absensi-kelas.per-bulan', {
                        tanggalAwal: data.tanggalAwal,
                        tanggalAkhir: data.tanggalAkhir,
                        kelasId: data.kelasId,
                        tahun: data.tahun
                    })} label='print per bulan' />
                </div>
            </div>
            <div className="py-2 capitalize font-bold text-slate-600">print per semester</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
                    listKelas={listKelas}
                    handleChange={onHandleChange}
                />

                <div className="flex items-end">
                    <PrintLink href={route('print-absensi-kelas.per-semester', {
                        tahun: data.tahun,
                        semester: data.semester,
                        kelasId: data.kelasId,
                    })} label='print per semester' />
                </div>
            </div>
        </>
    )
}

PrintAbsensiKelas.layout = page => <AppLayout children={page} />
export default PrintAbsensiKelas