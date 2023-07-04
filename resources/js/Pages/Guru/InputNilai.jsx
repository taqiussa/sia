import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getListJenis from '@/Functions/getListJenis'
import getListKategori from '@/Functions/getListKategori'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithNilai from '@/Functions/getSiswaWithNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputNilai = ({ initTahun, initSemester, listMapel }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        listKelas: [],
        listKategori: [],
        listJenis: [],
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaWithNilai(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setListSiswa(response.listSiswa)
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, data.mataPelajaranId)
        setData({
            ...data,
            listKelas: response.listKelas
        })
    }

    async function getDataKategori() {
        const response = await getListKategori(data.tahun, data.kelasId)
        setData({
            ...data,
            listKategori: response.listKategori
        })
    }

    async function getDataJenis() {
        const response = await getListJenis(data.tahun, data.semester, data.kategoriNilaiId, data.kelasId)
        setData({
            ...data,
            listJenis: response.listJenis
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('input-nilai.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Penilaian')
                    setData({ ...data })
                    getDataSiswa()
                },
            }
        )
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus Nilai!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('input-nilai.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Penilaian')
                                setData({ ...data })
                                getDataSiswa()
                            }
                        }
                    )
            })
    }

    const handleDouble = (e) => {
        e.preventDefault()

        Sweet.fire({
            title: 'Anda yakin menghapus?',
            text: "Hapus Nilai Ganda!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        })
            .then((hasil) => {
                if (hasil.isConfirmed)
                    post(route('input-nilai.ganda'), {
                        onSuccess: () => {
                            toast.success('Berhasil Hapus Data Ganda')
                            setData({ ...data })
                            getDataSiswa()
                        }
                    })
            })
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, kelasId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: namaSiswa
            },
            penilaian: {
                id: id,
                nilai: e.target.value
            }
        })


        setListSiswa(newList)

        setCount(count + 1)

    }

    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            trackPromise(getDataKelas())
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.kelasId)
            trackPromise(getDataKategori())
    }, [data.kelasId])

    useEffect(() => {

        if (data.kategoriNilaiId) {
            setData('jenisPenilaianId', '')
            trackPromise(getDataJenis())
        }
    }, [data.semester, data.kategoriNilaiId])

    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriNilaiId
            && data.jenisPenilaianId
        )
            trackPromise(
                getDataSiswa()
            )


    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    return (
        <>
            <Head title='Input Nilai' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input nilai</div>
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

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    handleChange={onHandleChange}
                    listKelas={data.listKelas}
                />

                <KategoriNilai
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={data.listKategori}
                />

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={data.listJenis}
                />

                <div className=' place-self-end'>
                    <PrimaryButton children='hapus ganda' onClick={handleDouble} disabled={processing} />
                </div>

            </div>

            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className='flex flex-col'>

                                        <InputText
                                            id='penilaian'
                                            name='penilaian'
                                            message={errors.penilaian}
                                            className='w-auto max-w-[60px]'
                                            value={siswa.penilaian.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian.id, siswa.nis, siswa.user.name, siswa.kelas_id)}
                                        />

                                        {data.arrayInput.length > 0 && data.arrayInput[index]?.penilaian.nilai > 100 && (
                                            <span className='text-red-500'>Nilai Maksimal 100</span>
                                        )}

                                    </div>
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {
                                        siswa.penilaian?.id && siswa.penilaian?.nilai &&
                                        <Hapus onClick={() => handleDelete(siswa.penilaian?.id)} />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className="flex justify-end pt-5">
                <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
            </div>
        </>
    )
}

InputNilai.layout = page => <AppLayout children={page} />
export default InputNilai