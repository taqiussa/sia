import PrimaryButton from '@/Components/PrimaryButton'
import Jam from '@/Components/Sia/Jam'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kehadiran from '@/Components/Sia/Kehadiran'
import Kelas from '@/Components/Sia/Kelas'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { arrayKehadiranKaryawan } from '@/Functions/functions'
import getAbsensiSiswa from '@/Functions/getAbsensiSiswa'
import getAbsensiSosial from '@/Functions/getAbsensiSosial'
import getInfoAbsensi from '@/Functions/getInfoAbsensi'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import axios from 'axios'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const Absensi = ({ initTahun, initSemester }) => {

    const { data, setData, errors, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        keterangan: ''
    })

    const [count, setCount] = useState(0)
    const [listUser, setListUser] = useState([])
    const [message, setMessage] = useState([])
    const [show, setShow] = useState(false)

    async function getDataAbsensiSiswa() {
        const response = await getAbsensiSosial(data.tanggal)
        setListUser(response.listUser)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, name, sosialDetailId, sosialId, JenisKelamin) => {

        const newList = [...listUser]
        newList.splice(index, 1, {
            id: id,
            name: name,
            jenis_kelamin: JenisKelamin,
            sosial_detail: {
                id: sosialDetailId,
                sosial_id: sosialId,
                kehadiran_id: e.target.value,
            }
        })

        setListUser(newList)
        setCount(count + 1)

        axios.post(route('input-sosial.simpan',
            {
                id: id,
                sosialId: sosialId,
                tahun: data.tahun,
                semester: data.semester,
                tanggal: data.tanggal,
                userId: id,
                JenisKelamin: JenisKelamin,
                kehadiranId: e.target.value
            }))
            .then(response => {

                setListUser(response.data.listUser)

                setMessage({
                    id: response.data.id,
                    message: response.data.message
                })
                getDataInfoAbsensi()
            })
            .catch(error => {
                console.log(error)
            })
    }

    const handleNihil = (e) => {
        e.preventDefault()

        trackPromise(
            axios.post(
                route('absensi.nihil',
                    {
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        jam: data.jam,
                        kelasId: data.kelasId,
                    })
            )
                .then(e => {
                    setListUser(e.data.listUser)
                    toast.success('Berhasil Set Kehadiran')
                })
                .catch(error => {
                    console.log(error)
                })
        )
    }

    useEffect(() => {

        if (data.tanggal && data.kelasId) {
            trackPromise(
                getDataInfoAbsensi()
            )
        }

        setShow(false)

        if (data.tanggal
            && data.tahun
            && data.jam
            && data.kelasId
        ) {
            trackPromise(
                getDataAbsensiSiswa()
            )

            setShow(true)
        }
    }, [data.tanggal, data.tahun, data.jam, data.kelasId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listUser],
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
            <Head title='Absensi' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">absensi</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    message={errors.tanggal}
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
                                Kehadiran
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listUser && listUser.map((user, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className='flex flex-col'>

                                        <Kehadiran
                                            id='kehadiranId'
                                            name='kehadiranId'
                                            message={errors.kehadiranId}
                                            value={user.sosial_detail?.kehadiran_id ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, user.id, user.name, user.sosial_detail?.id, user.sosial_detail.sosial_id, user.jenis_kelamin)}
                                            listKehadiran={arrayKehadiranKaryawan()}
                                        />

                                        {message && message.nis == siswa.nis &&
                                            (
                                                <span className='text-emerald-500'>{message.message}</span>
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

Absensi.layout = page => <AppLayout children={page} />
export default Absensi