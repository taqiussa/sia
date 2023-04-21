import JenisKelamin from '@/Components/Sia/JenisKelamin'
import PrintLink from '@/Components/Sia/PrintLink'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import Ujian from '@/Components/Sia/Ujian'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'

const PrintAbsensiUjian = ({ initTahun }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        namaUjian: '',
        jenisKelamin: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    return (
        <>
            <Head title='Print Absensi Ujian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">print absensi ujian</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                <Ujian
                    id="namaUjian"
                    name="namaUjian"
                    value={data.namaUjian}
                    message={errors.namaUjian}
                    handleChange={onHandleChange}
                />

                <JenisKelamin
                    id='jenisKelamin'
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
                />

                <div className="flex justify-start items-end">
                    <PrintLink href={route('print-absensi-ujian-print', {
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        namaUjian: data.namaUjian,
                        jenisKelamin: data.jenisKelamin
                    })} label='print' />
                </div>
            </div>
        </>
    )
}

PrintAbsensiUjian.layout = page => <AppLayout children={page} />
export default PrintAbsensiUjian