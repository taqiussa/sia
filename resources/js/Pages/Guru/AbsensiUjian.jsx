import PrimaryButton from '@/Components/PrimaryButton'
import Jam from '@/Components/Sia/Jam'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kehadiran from '@/Components/Sia/Kehadiran'
import Ruang from '@/Components/Sia/Ruang'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import Ujian from '@/Components/Sia/Ujian'
import getAbsensiUjian from '@/Functions/getAbsensiUjian'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import axios from 'axios'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const AbsensiUjian = ({ initTahun, listKehadiran }) => {

    const { data, setData, errors, processing } = useForm({
        id: '',
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        namaUjian: '',
        namaRuang: '',
        jenisKelamin: '',
        jam: '',
        nis: '',
        kehadiranId: ''
    })

    const [count, setCount] = useState(0)
    const [listSiswa, setListSiswa] = useState([])
    const [message, setMessage] = useState([])
    const [show, setShow] = useState(false)

    async function getDataAbsensiSiswa() {
        const response = await getAbsensiUjian(data.tanggal, data.tahun, data.namaUjian, data.namaRuang, data.jam, data.jenisKelamin)
        setListSiswa(response.listSiswa)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, name, guruName, namaKelas, kelasId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            id: id ?? '',
            nis: nis,
            kelas_id: kelasId,
            absensi: {
                guru: {
                    name: guruName
                },
                kehadiran_id: e.target.value,
            },
            kelas: {
                nama: namaKelas
            },
            user: {
                name: name
            },
        })

        setListSiswa(newList)
        setCount(count + 1)

        axios.post(route('absensi-ujian.simpan',
            {
                id: id,
                tanggal: data.tanggal,
                tahun: data.tahun,
                jam: data.jam,
                namaRuang: data.namaRuang,
                namaUjian: data.namaUjian,
                jenisKelamin: data.jenisKelamin,
                kehadiranId: e.target.value,
                kelasId: kelasId,
                nis: nis,
            }))
            .then(response => {
                setMessage({
                    nis: response.data.nis,
                    message: response.data.message
                })
            })
            .catch(error => {
                console.log(error)
            })
    }

    const handleNihil = (e) => {
        e.preventDefault()

        trackPromise(
            axios.post(
                route('absensi-ujian.nihil',
                    {
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        jam: data.jam,
                        namaRuang: data.namaRuang,
                        namaUjian: data.namaUjian,
                        jenisKelamin: data.jenisKelamin
                    })
            )
                .then(e => {
                    setListSiswa(e.data.listSiswa)
                    toast.success('Berhasil Set Kehadiran')
                })
                .catch(error => {
                    console.log(error)
                })
        )
    }

    useEffect(() => {

        setShow(false)

        if (data.tanggal
            && data.tahun
            && data.jam
            && data.namaRuang
            && data.namaUjian
            && data.jenisKelamin
        ) {
            trackPromise(
                getDataAbsensiSiswa()
            )

            setShow(true)
        }
    }, [data.tanggal, data.tahun, data.jam, data.namaUjian, data.namaRuang, data.jenisKelamin])

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
            <Head title='Absensi Ujian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">absensi ujian</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                <Ujian
                    id="namaUjian"
                    name="namaUjian"
                    value={data.namaUjian}
                    message={errors.namaUjian}
                    handleChange={onHandleChange}
                />

                <Ruang
                    id="namaRuang"
                    name="namaRuang"
                    value={data.namaRuang}
                    message={errors.namaRuang}
                    handleChange={onHandleChange}
                />

                <Jam
                    id='jam'
                    name='jam'
                    value={data.jam}
                    message={errors.jam}
                    handleChange={onHandleChange}
                />

                <JenisKelamin
                    id='jenisKelamin'
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
                />

            </div>

            {
                show && (
                    <PrimaryButton onClick={handleNihil} disabled={processing}>set hadir</PrimaryButton>
                )
            }

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
                                Kehadiran
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Guru
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

                                        <Kehadiran
                                            id='kehadiranId'
                                            name='kehadiranId'
                                            message={errors.kehadiranId}
                                            value={siswa.absensi.kehadiran_id ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.absensi?.id, siswa.nis, siswa.user.name, siswa.absensi.guru?.name, siswa.kelas?.nama, siswa.kelas_id)}
                                            listKehadiran={listKehadiran}
                                        />

                                        {message && message.nis == siswa.nis &&
                                            (
                                                <span className='text-emerald-500'>{message.message}</span>
                                            )}

                                    </div>
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.absensi.guru?.name}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

AbsensiUjian.layout = page => <AppLayout children={page} />
export default AbsensiUjian