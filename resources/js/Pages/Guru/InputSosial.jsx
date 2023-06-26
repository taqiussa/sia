import PrimaryButton from '@/Components/PrimaryButton'
import InputArea from '@/Components/Sia/InputArea'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kategori from '@/Components/Sia/Kategori'
import Kehadiran from '@/Components/Sia/Kehadiran'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { arrayKategoriRole, arrayKehadiranKaryawan } from '@/Functions/functions'
import getAbsensiSosial from '@/Functions/getAbsensiSosial'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import axios from 'axios'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputSosial = ({ initTahun, initSemester }) => {

    const { data, setData, errors, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        keterangan: '',
        jenisKelamin: '',
        role: ''
    })

    const [count, setCount] = useState(0)
    const [listUser, setListUser] = useState([])
    const [message, setMessage] = useState([])
    const [show, setShow] = useState(false)

    async function getDataAbsensiSosial() {
        const response = await getAbsensiSosial(data.tanggal, data.role, data.jenisKelamin)
        setListUser(response.listUser)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, name, sosialDetailId, sosialId) => {

        const newList = [...listUser]
        newList.splice(index, 1, {
            id: id,
            name: name,
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
                id: sosialDetailId,
                sosialId: sosialId,
                tahun: data.tahun,
                semester: data.semester,
                tanggal: data.tanggal,
                userId: id,
                jenisKelamin: data.jenisKelamin,
                keterangan: data.keterangan,
                kehadiranId: e.target.value
            }))
            .then(response => {

                setData({ ...data })
                trackPromise(getDataAbsensiSosial())

                setMessage({
                    id: response.data.id,
                    message: response.data.message
                })
            })
            .catch(error => {
                Sweet
                    .fire({
                        text: 'Keterangan Belum di Isi',
                        icon: 'error'
                    })
            })
    }

    const handleNihil = (e) => {
        e.preventDefault()

        trackPromise(
            axios.post(
                route('input-sosial.nihil',
                    {
                        tahun: data.tahun,
                        semester: data.semester,
                        tanggal: data.tanggal,
                        keterangan: data.keterangan,
                        jenisKelamin: data.jenisKelamin,
                        role: data.role
                    })
            )
                .then(e => {
                    toast.success('Berhasil Set Kehadiran')
                    setData({ ...data })
                    trackPromise(getDataAbsensiSosial())
                })
                .catch(error => {
                    console.log(error)
                })
        )
    }

    useEffect(() => {

        setShow(false)
        setListUser([])
        if (data.tanggal
            && data.tahun
            && data.role
            && data.jenisKelamin
        ) {
            trackPromise(
                getDataAbsensiSosial()
            )

            setShow(true)
        }
    }, [data.tanggal, data.tahun, data.role, data.jenisKelamin])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listUser],
        })


    }, [count])

    return (
        <>
            <Head title='Input Sosial' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input sosial</div>
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

                <Kategori
                    name='role'
                    value={data.role}
                    message={errors.role}
                    handleChange={onHandleChange}
                    listKategori={arrayKategoriRole()}
                />

                <JenisKelamin
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
                />


                <div className="col-span-4">
                    <InputArea
                        name='keterangan'
                        label='keterangan'
                        value={data.keterangan}
                        handleChange={onHandleChange}
                    />
                </div>

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
                                            handleChange={(e) => handleDynamic(e, index, user.id, user.name, user.sosial_detail?.id, user.sosial_detail.sosial_id)}
                                            listKehadiran={arrayKehadiranKaryawan()}
                                        />

                                        {message && message.id == user.id &&
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

InputSosial.layout = page => <AppLayout children={page} />
export default InputSosial