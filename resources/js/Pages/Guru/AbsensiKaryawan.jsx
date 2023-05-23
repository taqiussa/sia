import PrimaryButton from '@/Components/PrimaryButton'
import Jam from '@/Components/Sia/Jam'
import Kehadiran from '@/Components/Sia/Kehadiran'
import Kelas from '@/Components/Sia/Kelas'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import getAbsensiSiswa from '@/Functions/getAbsensiSiswa'
import getInfoAbsensi from '@/Functions/getInfoAbsensi'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import axios from 'axios'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const AbsensiKaryawan = ({ ip }) => {

    // const { data, setData, errors, processing } = useForm({
    //     id: '',
    //     tahun: initTahun,
    //     tanggal: moment(new Date()).format('YYYY-MM-DD'),
    //     jam: '',
    //     kelasId: '',
    //     nis: '',
    //     kehadiranId: ''
    // })

    // const [count, setCount] = useState(0)
    // const [listInfo, setListInfo] = useState([])
    // const [listSiswa, setListSiswa] = useState([])
    // const [message, setMessage] = useState([])
    // const [show, setShow] = useState(false)

    // async function getDataAbsensiSiswa() {
    //     const response = await getAbsensiSiswa(data.tanggal, data.tahun, data.jam, data.kelasId)
    //     setListSiswa(response.listSiswa)
    // }

    // async function getDataInfoAbsensi() {
    //     const response = await getInfoAbsensi(data.tanggal, data.kelasId)
    //     setListInfo(response.listInfo)
    // }

    // const onHandleChange = (e) => {
    //     setData(e.target.name, e.target.value)
    // }

    // const handleDynamic = (e, index, id, nis, name, guruName) => {

    //     const newList = [...listSiswa]
    //     newList.splice(index, 1, {
    //         id: id ?? '',
    //         nis: nis,
    //         user: {
    //             name: name
    //         },
    //         absensi: {
    //             kehadiran_id: e.target.value,
    //             guru: {
    //                 name: guruName
    //             },
    //         }
    //     })

    //     setListSiswa(newList)
    //     setCount(count + 1)

    //     axios.post(route('absensi.simpan',
    //         {
    //             id: id,
    //             tanggal: data.tanggal,
    //             tahun: data.tahun,
    //             jam: data.jam,
    //             kelasId: data.kelasId,
    //             nis: nis,
    //             kehadiranId: e.target.value
    //         }))
    //         .then(response => {

    //             setListSiswa(response.data.listSiswa)

    //             setMessage({
    //                 nis: response.data.nis,
    //                 message: response.data.message
    //             })
    //             getDataInfoAbsensi()
    //         })
    //         .catch(error => {
    //             console.log(error)
    //         })
    // }

    // const handleNihil = (e) => {
    //     e.preventDefault()

    //     trackPromise(
    //         axios.post(
    //             route('absensi.nihil',
    //                 {
    //                     tanggal: data.tanggal,
    //                     tahun: data.tahun,
    //                     jam: data.jam,
    //                     kelasId: data.kelasId,
    //                 })
    //         )
    //             .then(e => {
    //                 setListSiswa(e.data.listSiswa)
    //                 toast.success('Berhasil Set Kehadiran')
    //             })
    //             .catch(error => {
    //                 console.log(error)
    //             })
    //     )
    // }

    // useEffect(() => {

    //     if (data.tanggal && data.kelasId) {
    //         trackPromise(
    //             getDataInfoAbsensi()
    //         )
    //     }

    //     setShow(false)

    //     if (data.tanggal
    //         && data.tahun
    //         && data.jam
    //         && data.kelasId
    //     ) {
    //         trackPromise(
    //             getDataAbsensiSiswa()
    //         )

    //         setShow(true)
    //     }
    // }, [data.tanggal, data.tahun, data.jam, data.kelasId])

    // useEffect(() => {

    //     setData({
    //         ...data,
    //         arrayInput: [...listSiswa],
    //     })


    // }, [count])

    // useEffect(() => {

    //     const timeoutId = setTimeout(() => {
    //         setMessage([]);
    //     }, 1000);

    //     return () => {
    //         clearTimeout(timeoutId);
    //     };
    // }, [message])
    return (
        <>
            <Head title='Absensi' />
            <div className='pl-10 pt-10 text-slate-600 text-lg'>Selamat Datang di Sistem Akademik SMP Al Musyaffa</div>
            <div className='pl-10 pt-10 text-slate-600 text-lg'>IP anda : {ip}</div>

            {/* <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">absensi</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
                    listKelas={listKelas}
                    handleChange={onHandleChange}
                />
            </div>

            {
                show && (
                    <PrimaryButton onClick={handleNihil} disabled={processing}>set hadir</PrimaryButton>
                )
            }

            <div className='text-slate-600 py-2'>
                Informasi :
                {listInfo && listInfo.map((info, index) => (
                    <li key={index}>{index + 1}. {info.siswa?.name} - {info.kehadiran?.nama} - {info.jam}</li>
                ))}
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
                                    {siswa.user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className='flex flex-col'>

                                        <Kehadiran
                                            id='kehadiranId'
                                            name='kehadiranId'
                                            message={errors.kehadiranId}
                                            value={siswa.absensi.kehadiran_id ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.absensi?.id, siswa.nis, siswa.user.name, siswa.absensi.guru?.name)}
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
            </div> */}
        </>
    )
}

AbsensiKaryawan.layout = page => <AppLayout children={page} />
export default AbsensiKaryawan