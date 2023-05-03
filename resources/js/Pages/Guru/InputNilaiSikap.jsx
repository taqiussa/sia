import InputTextBlur from '@/Components/Sia/InputTextBlur'
import JenisSikap from '@/Components/Sia/JenisSikap'
import KategoriSikap from '@/Components/Sia/KategoriSikap'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getSiswaWithNilaiSikap from '@/Functions/getSiswaWithNilaiSikap'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import axios from 'axios'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const InputNilaiSikap = ({ initTahun, initSemester, listKelas, listMapel, listKategori, listJenis }) => {

    const { data, setData, post, errors, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
        mataPelajaranId: '',
        kategoriSikapId: '',
        jenisSikapId: '',
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)
    const [message, setMessage] = useState([])

    async function getDataSiswa() {
        const response = await getSiswaWithNilaiSikap(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId)

        setListSiswa(response.listSiswa)
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

        setMessage([])

        setListSiswa(newList)

        setCount(count + 1)
    }

    const onHandleBlur = (e, id, nis, kelasId) => {
        e.preventDefault()

        axios.post(route('input-nilai-sikap.simpan', {
            id: id,
            tahun: data.tahun,
            semester: data.semester,
            mataPelajaranId: data.mataPelajaranId,
            kategoriSikapId: data.kategoriSikapId,
            jenisSikapId: data.jenisSikapId,
            nis: nis,
            kelasId: kelasId,
            nilai: e.target.value
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
        if (
            data.tahun
            && data.mataPelajaranId
        )
            router.reload({
                only: ['listKelas'],
                data: {
                    tahun: data.tahun,
                    mataPelajaranId: data.mataPelajaranId
                }
            })

    }, [data.mataPelajaranId])

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
                    listKelas={listKelas}
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
                                            id='penilaianSikap'
                                            name='penilaianSikap'
                                            className='w-auto max-w-[60px]'
                                            value={siswa.penilaian_sikap.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian_sikap.id, siswa.nis, siswa.user.name, siswa.kelas_id)}
                                            handleBlur={(e) => onHandleBlur(e, siswa.penilaian_sikap.id, siswa.nis, siswa.kelas_id)}
                                        />

                                        {message && message.nis == siswa.nis &&
                                            (
                                                <span className='text-emerald-500'>{message.message}</span>
                                            )}

                                        {data.arrayInput.length > 0 && data.arrayInput[index]?.penilaian_sikap.nilai > 100 && (
                                            <span className='text-red-500'>Nilai Maksimal 100</span>
                                        )}

                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

InputNilaiSikap.layout = page => <AppLayout children={page} />
export default InputNilaiSikap