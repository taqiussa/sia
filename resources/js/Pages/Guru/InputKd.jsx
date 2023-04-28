import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tingkat from '@/Components/Sia/Tingkat'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { toast } from 'react-toastify'

const InputKd = ({ initTahun, initSemester, listMapel, listKategori, listJenis, listKd }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        tingkat: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        deskripsi: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-kd.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan KD / TP')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId,
                    tingkat: data.tingkat,
                    kategoriNilaiId: data.kategoriNilaiId,
                    jenisPenilaianId: data.jenisPenilaianId,
                    deskripsi: data.deskripsi
                })
            }
        })
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Menghapus KD/TP',
                text: 'Anda Yakin Menghapus Data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('input-kd.hapus',
                            {
                                id: id,
                                tahun: data.tahun,
                                semester: data.semester,
                                mataPelajaranId: data.mataPelajaranId
                            }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus KD/TP')
                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    mataPelajaranId: data.mataPelajaranId,
                                    tingkat: data.tingkat,
                                    kategoriNilaiId: data.kategoriNilaiId,
                                    jenisPenilaianId: data.jenisPenilaianId,
                                    deskripsi: data.deskripsi
                                })
                            }
                        })
            })
    }

    useEffect(() => {
        if (
            data.tahun
            && data.mataPelajaranId
            && data.tingkat
        )
            router.reload({
                only: ['listKategori'],
                data: {
                    tahun: data.tahun,
                    mataPelajaranId: data.mataPelajaranId,
                    tingkat: data.tingkat
                }
            })

    }, [data.mataPelajaranId, data.tingkat])

    useEffect(() => {
        if (
            data.tahun
            && data.mataPelajaranId
            && data.tingkat
        )
            router.reload({
                only: ['listJenis'],
                data: {
                    tahun: data.tahun,
                    semester: data.semester,
                    kategoriNilaiId: data.kategoriNilaiId
                }
            })

    }, [data.kategoriNilaiId])

    useEffect(() => {
        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
        )
            router.reload({
                only: ['listKd'],
                data: {
                    tahun: data.tahun,
                    semester: data.semester,
                    mataPelajaranId: data.mataPelajaranId
                },
                replace: true,
                preserveState: true
            })
    }, [data.tahun, data.semester, data.mataPelajaranId])
    return (
        <>
            <Head title='Input KD/TP' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-lg text-center text-slate-600 uppercase mb-2">input KD / TP</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                <MataPelajaran
                    id='mataPelajaranId'
                    name='mataPelajaranId'
                    value={data.mataPelajaranId}
                    message={errors.mataPelajaranId}
                    handleChange={onHandleChange}
                    listMapel={listMapel}
                />

                <Tingkat
                    id='tingkat'
                    name='tingkat'
                    value={data.tingkat}
                    message={errors.tingkat}
                    handleChange={onHandleChange}
                />

                <KategoriNilai
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={listJenis}
                />

            </div>

            <InputArea
                id='deskripsi'
                name='deskripsi'
                label='deskripsi KD/TP'
                className='mb-2'
                value={data.deskripsi}
                handleChange={onHandleChange}
            />

            <PrimaryButton children='simpan' onClick={submit} disabled={processing} />

            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tingkat
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kategori Nilai
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jenis Penilaian
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Deskripsi KD / TP
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listKd && listKd.map((kd, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kd.tingkat}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kd.kategori.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kd.jenis.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kd.deskripsi}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus
                                        onClick={() => handleDelete(kd.id)}
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

InputKd.layout = page => <AppLayout children={page} />
export default InputKd