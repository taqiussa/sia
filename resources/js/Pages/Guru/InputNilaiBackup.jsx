import Hapus from '@/Components/Sia/Hapus'
import InputTextBlur from '@/Components/Sia/InputTextBlur'
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

const InputNilaiBackup = ({ initTahun, initSemester, listMapel }) => {

    const { data, setData, post, errors, processing } = useForm({
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
    const [message, setMessage] = useState([])
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

        setMessage([])

        setListSiswa(newList)

        setCount(count + 1)

    }

    const onHandleBlur = (e, id, nis, kelasId) => {
        e.preventDefault()

        axios.post(route('input-nilai.simpan', {
            id: id,
            tahun: data.tahun,
            semester: data.semester,
            mataPelajaranId: data.mataPelajaranId,
            kategoriNilaiId: data.kategoriNilaiId,
            jenisPenilaianId: data.jenisPenilaianId,
            nis: nis,
            kelasId: kelasId,
            nilai: e.target.value,
        }))
            .then(response => {

                setListSiswa(response.data.listSiswa)

                setMessage({
                    nis: response.data.nis,
                    message: response.data.message
                })
            })
            .catch(error => {
                Sweet
                    .fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.response.data.message
                    })
            })
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

    useEffect(() => {

        const timeoutId = setTimeout(() => {
            setMessage([]);
        }, 1000);

        return () => {
            clearTimeout(timeoutId);
        };
    }, [message])

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

                                        <InputTextBlur
                                            id='penilaian'
                                            name='penilaian'
                                            message={errors.penilaian}
                                            className='w-auto max-w-[60px]'
                                            value={siswa.penilaian.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian.id, siswa.nis, siswa.user.name, siswa.kelas_id)}
                                            handleBlur={(e) => onHandleBlur(e, siswa.penilaian.id, siswa.nis, siswa.kelas_id)}
                                        />

                                        {message && message.nis == siswa.nis &&
                                            (
                                                <span className='text-emerald-500'>{message.message}</span>
                                            )}

                                        {data.arrayInput.length > 0 && data.arrayInput[index]?.penilaian.nilai > 100 && (
                                            <span className='text-red-500'>Nilai Maksimal 100</span>
                                        )}

                                    </div>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {
                                            siswa.penilaian?.id &&
                                            <Hapus onClick={() => handleDelete(siswa.penilaian?.id)} />
                                        }
                                    </td>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

InputNilaiBackup.layout = page => <AppLayout children={page} />
export default InputNilaiBackup