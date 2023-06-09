import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import Jam from '@/Components/Sia/Jam'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getListTugas from '@/Functions/getListTugas'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const FormTugas = ({ initTahun, listMapel }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        mataPelajaranId: '',
        jam: '',
        kelasId: '',
        tugas: '',
        listKelas: [],
        listTugas: []
    })

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, data.mataPelajaranId)
        setData({
            ...data,
            listKelas: response.listKelas,
        })
    }

    async function getDataTugas() {
        const response = await getListTugas(data.tanggal)
        setData({
            ...data,
            listTugas: response.listTugas
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('form-tugas.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Tugas Kelas')
                setData({ ...data })
                trackPromise(getDataTugas())
            },
            onError: (e) => {
                Sweet
                    .fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: e.pesan ?? 'Ada data kosong!',
                    })
            }
        })
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Anda Yakin Menghapus ?',
                text: 'Hapus Form Tugas',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(
                        route('form-tugas.hapus', {
                            id: id,
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Tugas')
                                setData({ ...data })
                                trackPromise(getDataTugas())
                            }
                        }
                    )
                }
            })
    }

    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            trackPromise(
                getDataKelas()
            )
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.tanggal && data.tahun)
            trackPromise(
                getDataTugas()
            )
    }, [data.tanggal, data.tahun])

    return (
        <>
            <Head title='Form Tugas' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">form tugas</div>
            <form onSubmit={submit} className='space-y-2'>
                <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                    <MataPelajaran
                        id='mataPelajaranId'
                        name='mataPelajaranId'
                        value={data.mataPelajaranId}
                        message={errors.mataPelajaranId}
                        handleChange={onHandleChange}
                        listMapel={listMapel}
                    />

                    <Jam
                        id='jam'
                        name='jam'
                        value={data.jam}
                        message={errors.jam}
                        handleChange={onHandleChange}
                    />

                    <Kelas
                        id='kelasId'
                        name='kelasId'
                        value={data.kelasId}
                        message={errors.kelasId}
                        handleChange={onHandleChange}
                        listKelas={data.listKelas}
                    />
                </div>
                <div>
                    <InputArea
                        id='tugas'
                        name='tugas'
                        value={data.tugas}
                        message={errors.tugas}
                        handleChange={onHandleChange}
                    />
                </div>
                <PrimaryButton onClick={submit} children='simpan' disabled={processing} />
            </form>

            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tugas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Badal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listTugas && data.listTugas.map((tugas, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {tugas.jam}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {tugas.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {tugas.tugas}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {tugas.badal?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus
                                        onClick={() => handleDelete(tugas.id)}
                                    />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

FormTugas.layout = page => <AppLayout children={page} />
export default FormTugas