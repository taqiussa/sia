import Tanggal from '@/Components/Sia/Tanggal'
import getAllSiswa from '@/Functions/getAllSiswa'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment/moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const BimbinganIndividu = ({ initTahun, listKelas }) => {

    const { data, setData, post, errors, processing } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        jenisBimbingan: '',
        permasalahan: '',
        penyelesaian: '',
        tindakLanjut: '',
        nis: '',
        kelasId: '',
        foto: '',
        fotoDokumen: ''
    })

    const [listSiswa, setListSiswa] = useState([])

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getAllSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    const submit = (e) => {
        e.preventDefault()

        post(
            route('bimbingan-individu.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Bimbingan')
                    setData({
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        jenisBimbingan: '',
                        permasalahan: '',
                        penyelesaian: '',
                        tindakLanjut: '',
                        nis: '',
                        kelasId: '',
                        foto: '',
                        fotoDokumen: ''
                    })
                }
            }
        )
    }

    useEffect(() => {
        if (data.tahun && data.kelasId)
            trackPromise(
                getData()
            )
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Bimbingan Individu' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">absensi</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    message={errors.tanggal}
                    handleChange={onHandleChange}
                />
                
            </div>
        </>
    )
}

BimbinganIndividu.layout = page => <AppLayout children={page} />
export default BimbinganIndividu