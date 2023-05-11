import PrimaryButton from '@/Components/PrimaryButton'
import FileUpload from '@/Components/Sia/FileUpload'
import InputArea from '@/Components/Sia/InputArea'
import JenisBimbingan from '@/Components/Sia/JenisBimbingan'
import Kelas from '@/Components/Sia/Kelas'
import Siswa from '@/Components/Sia/Siswa'
import Tanggal from '@/Components/Sia/Tanggal'
import getSiswa from '@/Functions/getSiswa'
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
        const response = await getSiswa(data.tahun, data.kelasId)
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

                <JenisBimbingan
                    id='jenisBimbingan'
                    name='jenisBimbingan'
                    value={data.jenisBimbingan}
                    message={errors.jenisBimbingan}
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

                <Siswa
                    id='nis'
                    name='nis'
                    value={data.nis}
                    message={errors.nis}
                    listSiswa={listSiswa}
                    handleChange={onHandleChange}
                />

            </div>

            <div className='lg:grid lg:grid-cols-3 lg:gap-2 lg:space-y-0 space-y-3'>

                <InputArea
                    id='permasalahan'
                    name='permasalahan'
                    label='permasalahan'
                    rows={4}
                    value={data.permasalahan}
                    message={errors.permasalahan}
                    handleChange={onHandleChange}
                />

                <InputArea
                    id='penyelesaian'
                    name='penyelesaian'
                    label='penyelesaian'
                    rows={4}
                    value={data.penyelesaian}
                    message={errors.penyelesaian}
                    handleChange={onHandleChange}
                />

                <InputArea
                    id='tindakLanjut'
                    name='tindakLanjut'
                    label='tindak lanjut'
                    rows={4}
                    value={data.tindakLanjut}
                    message={errors.tindakLanjut}
                    handleChange={onHandleChange}
                />
            </div>
            <div className='lg:flex lg:flex-row lg:space-y-0 lg:space-x-3 space-x-0 space-y-3'>

                <FileUpload
                    id='foto'
                    label='foto'
                    name='foto'
                    message={errors.foto}
                    handleChange={onHandleChange}
                />

                <FileUpload
                    id='fotoDokumen'
                    label='foto dokumen'
                    name='fotoDokumen'
                    message={errors.fotoDokumen}
                    handleChange={onHandleChange}
                />

                <div className='flex flex-col'>
                    <div>
                        &nbsp;
                    </div>
                    <div>
                        <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
                    </div>
                </div>

            </div>
        </>
    )
}

BimbinganIndividu.layout = page => <AppLayout children={page} />
export default BimbinganIndividu