import Tahun from '@/Components/Sia/Tahun'
import Tingkat from '@/Components/Sia/Tingkat'
import getKdPerTingkat from '@/Functions/getKdPerTingkat'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const CekKd = ({ initTahun, listMapel }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        tingkat: '',
        listKd: []
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataKd() {
        const res = await getKdPerTingkat(data.tahun, data.tingkat)
        setData({ ...data, listKd: res.listKd })
    }

    useEffect(() => {
        if (data.tahun && data.tingkat)
            trackPromise(getDataKd())
    }, [data.tahun, data.tingkat])

    return (
        <>
            <Head title='Cek Kd' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">cek KD/TP</div>
            <div className="lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3 mb-3">
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Tingkat
                    name='tingkat'
                    value={data.tingkat}
                    handleChange={onHandleChange}
                />
            </div>
        </>
    )
}

export default CekKd