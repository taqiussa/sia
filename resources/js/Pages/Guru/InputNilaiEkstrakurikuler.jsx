import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import InputTextBlur from '@/Components/Sia/InputTextBlur'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import getSiswaEkstraWithNilai from '@/Functions/getSiswaEkstraWithNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import axios from 'axios'
import { list } from 'postcss'
import React from 'react'
import { useEffect } from 'react'
import { useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const InputNilaiEkstrakurikuler = ({ initTahun, initSemester, listEkstrakurikuler }) => {

    const { data, setData, errors, post, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        ekstrakurikulerId: '',
        jenisKelamin: '',
        nis: '',
        nilai: '',
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [message, setMessage] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaEkstraWithNilai(data.tahun, data.semester, data.ekstrakurikulerId, data.jenisKelamin)
        setListSiswa(response.listSiswa)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, namaKelas, kelasId, ekstrakurikulerId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            ekstrakurikuler_id: ekstrakurikulerId,
            user: {
                name: namaSiswa
            },
            kelas: {
                nama: namaKelas
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

        axios.post(route('input-nilai-ekstrakurikuler.simpan', {
            id: id,
            tahun: data.tahun,
            semester: data.semester,
            ekstrakurikulerId: data.ekstrakurikulerId,
            jenisKelamin: data.jenisKelamin,
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
    }


    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.ekstrakurikulerId
            && data.jenisKelamin
        )
            trackPromise(
                getDataSiswa()
            )


    }, [data.tahun, data.semester, data.ekstrakurikulerId, data.jenisKelamin])

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
            <Head title='Absensi Ekstrakurikuler' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input nilai ekstrakurikuler</div>
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

                <Ekstrakurikuler
                    id='ekstrakurikulerId'
                    name='ekstrakurikulerId'
                    value={data.ekstrakurikulerId}
                    message={errors.ekstrakurikulerId}
                    handleChange={onHandleChange}
                    listEkstrakurikuler={listEkstrakurikuler}
                />

                <JenisKelamin
                    id='jenisKelamin'
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
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
                                Kelas
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
                                    {siswa.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className='flex flex-col'>

                                        <InputTextBlur
                                            id='penilaian'
                                            name='penilaian'
                                            message={errors.penilaian}
                                            value={siswa.penilaian.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian.id, siswa.nis, siswa.user.name, siswa.kelas?.nama, siswa.kelas_id, siswa.ekstrakurikuler_id)}
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
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
InputNilaiEkstrakurikuler.layout = page => <AppLayout children={page} />
export default InputNilaiEkstrakurikuler