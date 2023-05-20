import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import JenisSikap from '@/Components/Sia/JenisSikap'
import KategoriSikap from '@/Components/Sia/KategoriSikap'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithNilaiSikap from '@/Functions/getSiswaWithNilaiSikap'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputNilaiSikap = ({ initTahun, initSemester, listMapel, listKategori, listJenis }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
        mataPelajaranId: '',
        kategoriSikapId: '',
        jenisSikapId: '',
        listKelas: [],
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaWithNilaiSikap(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId)

        setListSiswa(response.listSiswa)
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, data.mataPelajaranId)
        setData({
            ...data,
            listKelas: response.listKelas
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, kelasId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: namaSiswa
            },
            penilaian_sikap: {
                id: id,
                nilai: e.target.value,
            }
        })

        setListSiswa(newList)

        setCount(count + 1)
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('input-nilai-sikap.simpan'),
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
                        route('input-nilai-sikap.hapus', { id: id }),
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

    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            trackPromise(getDataKelas())
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriSikapId
            && data.jenisSikapId
        ) {

            trackPromise(
                getDataSiswa()
            )
        } else {
            setListSiswa([])
        }


    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    return (
        <>
            <Head title='Input Nilai Sikap' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">input nilai sikap</div>
            <div className="grid grid-cols-2 gap-2 space-y-2 lg:grid lg:grid-cols-4  lg:gap-2 lg:space-y-0">

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

                <KategoriSikap
                    id='kategoriSikapId'
                    name='kategoriSikapId'
                    value={data.kategoriSikapId}
                    message={errors.kategoriSikapId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />

                <JenisSikap
                    id='jenisSikapId'
                    name='jenisSikapId'
                    value={data.jenisSikapId}
                    message={errors.jenisSikapId}
                    handleChange={onHandleChange}
                    listJenis={listJenis}
                />

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
                                            id='penilaianSikap'
                                            name='penilaianSikap'
                                            className='w-auto max-w-[60px]'
                                            value={siswa.penilaian_sikap.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian_sikap.id, siswa.nis, siswa.user.name, siswa.kelas_id)}
                                        />

                                        {data.arrayInput.length > 0 && data.arrayInput[index]?.penilaian_sikap.nilai > 100 && (
                                            <span className='text-red-500'>Nilai Maksimal 100</span>
                                        )}

                                    </div>
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.penilaian_sikap?.id &&
                                        <Hapus onClick={() => handleDelete(siswa.penilaian_sikap?.id)} />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className="flex justify-end py-5">
                <PrimaryButton onClick={submit} children='simpan' disabled={processing} />
            </div>
        </>
    )
}

InputNilaiSikap.layout = page => <AppLayout children={page} />
export default InputNilaiSikap