import KategoriNilaiKaryawan from '@/Components/Sia/KategoriNilaiKaryawan'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import Header from '@/Layouts/Partials/Header'
import { Head, router, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'

const HasilPenilaianGuru = ({ initTahun, listKategori, listJenis }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        kategoriNilaiId: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.kategoriNilaiId) {
            router.reload({
                only: ['listJenis'],
                data: {
                    tahun: data.tahun,
                    kategoriNilaiId: data.kategoriNilaiId
                },
                preserveState: true,
                replace: true
            })
        }

    }, [data.tahun, data.kategoriNilaiId])

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

            </div>
        </>
    )
}

HasilPenilaianGuru.layout = page => <AppLayout children={page} />
export default HasilPenilaianGuru