import Kelas from '@/Components/Sia/Kelas'
import PrintLink from '@/Components/Sia/PrintLink'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getDataKelasWaliKelas from '@/Functions/getDataKelasWaliKelas'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const PrintLedgerPts = ({ initTahun, initSemester, listKelas }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getDataKelasWaliKelas(data.tahun)
        setData('kelasId', response.kelasId)
    }

    useEffect(() => {
        if (data.tahun) {
            trackPromise(
                getData()
            )
        }
    }, [data.tahun])

    return (
        <>
            <Head title='Print Ledger PTS' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">print ledger pts</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                    disabled={true}
                />
                <div className="flex items-end">
                    <PrintLink href={route('print-ledger-pts.print', {
                        tahun: data.tahun,
                        semester: data.semester,
                        kelasId: data.kelasId
                    })} label='print' />
                </div>
            </div>

        </>
    )
}

PrintLedgerPts.layout = page => <AppLayout children={page} />
export default PrintLedgerPts