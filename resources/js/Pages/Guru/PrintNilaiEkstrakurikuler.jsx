import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import PrintLinkMerah from '@/Components/Sia/PrintLinkMerah'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'

const PrintNilaiEkstrakurikuler = ({ initTahun, initSemester, listKelas, listEkstrakurikuler }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
        ekstrakurikulerId: '',
        jenisKelamin: ''
    })


    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    return (
        <>
            <Head title='Print Nilai Ekstrakurikuler' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">print nilai ekstrakurikuler</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
            </div>

            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                />

                <div className="flex items-end">
                    <PrintLink
                        href={route('print-nilai-ekstrakurikuler.per-kelas', {
                            tahun: data.tahun,
                            semester: data.semester,
                            kelasId: data.kelasId
                        })}
                        label='per kelas'
                    />
                </div>
            </div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
                    <PrintLinkMerah
                        href={route('print-nilai-ekstrakurikuler.per-ekstrakurikuler', {
                            tahun: data.tahun,
                            semester: data.semester,
                            ekstrakurikulerId: data.ekstrakurikulerId,
                            jenisKelamin: data.jenisKelamin
                        })}
                        label='per ekstrakurikuler'
                    />
                </div>
            </div>
        </>
    )
}

PrintNilaiEkstrakurikuler.layout = page => <AppLayout children={page} />
export default PrintNilaiEkstrakurikuler