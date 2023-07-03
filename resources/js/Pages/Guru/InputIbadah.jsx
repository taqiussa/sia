import PrimaryButton from '@/Components/PrimaryButton'
import Bulan from '@/Components/Sia/Bulan'
import JenisIbadah from '@/Components/Sia/JenisIbadah'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kategori from '@/Components/Sia/Kategori'
import Kehadiran from '@/Components/Sia/Kehadiran'
import Minggu from '@/Components/Sia/Minggu'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { arrayJenisIbadah, arrayKategoriRole, arrayKehadiranKaryawan } from '@/Functions/functions'
import getAbsensiIbadah from '@/Functions/getAbsensiIbadah'
import AppLayout from '@/Layouts/AppLayout'
import Header from '@/Layouts/Partials/Header'
import { Head, useForm } from '@inertiajs/react'
import axios from 'axios'
import React from 'react'
import { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputIbadah = ({ initTahun }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        bulan: '',
        minggu: '',
        jenisIbadah: '',
        jenisKelamin: '',
        kategori: '',
        arrayInput: []
    })

    
    const [count, setCount] = useState(0)
    const [listUser, setListUser] = useState([])
    const [message, setMessage] = useState([])
    const [show, setShow] = useState(false)
    
    async function getDataAbsensiIbadah() {
        const response = await getAbsensiIbadah(data.tahun, data.bulan, data.minggu, data.jenisIbadah, data.kategori, data.jenisKelamin)
        setListUser(response.listUser)
    }
    
    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }
    console.log(listUser)
    
    const handleDynamic = (e, index, id, name, ibadahDetailId, ibadahId) => {

        const newList = [...listUser]
        newList.splice(index, 1, {
            id: id,
            name: name,
            ibadah_detail: {
                id: ibadahDetailId,
                ibadah_id: ibadahId,
                kehadiran_id: e.target.value,
            }
        })

        setListUser(newList)
        setCount(count + 1)

        axios.post(route('input-ibadah.simpan',
            {
                id: ibadahDetailId,
                userId: id,
                ibadahId: ibadahId,
                tahun: data.tahun,
                bulan: data.bulan,
                minggu: data.minggu,
                jenisIbadah: data.jenisIbadah,
                kategori: data.kategori,
                jenisKelamin: data.jenisKelamin,
                kehadiranId: e.target.value,
            }))
            .then(response => {

                setData({ ...data })
                trackPromise(getDataAbsensiIbadah())

                setMessage({
                    id: response.data.id,
                    message: response.data.message
                })
            })
    }

    const handleNihil = (e) => {
        e.preventDefault()

        trackPromise(
            axios.post(
                route('input-ibadah.nihil',
                    {
                        tahun: data.tahun,
                        bulan: data.bulan,
                        minggu: data.minggu,
                        jenisIbadah: data.jenisIbadah,
                        kategori: data.kategori,
                        jenisKelamin: data.jenisKelamin,
                    })
            )
                .then(e => {
                    toast.success('Berhasil Set Kehadiran')
                    setData({ ...data })
                    trackPromise(getDataAbsensiIbadah())
                })
                .catch(error => {
                    console.log(error)
                })
        )
    }

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listUser],
        })


    }, [count])

    useEffect(() => {

        setShow(false)
        setListUser([])

        if (
            data.tahun
            && data.bulan
            && data.minggu
            && data.jenisIbadah
            && data.kategori
            && data.jenisKelamin) {
            trackPromise(getDataAbsensiIbadah())
            setShow(true)

        }

    }, [data.tahun, data.bulan, data.minggu, data.jenisIbadah, data.kategori, data.jenisKelamin])

    return (
        <>
            <Head title='Input Ibadah' />
            <Header title='input ibadah' />
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    name='bulan'
                    value={data.bulan}
                    message={errors.bulan}
                    handleChange={onHandleChange}
                />

                <Minggu
                    name='minggu'
                    value={data.minggu}
                    message={errors.minggu}
                    handleChange={onHandleChange}
                />

                <JenisIbadah
                    name='jenisIbadah'
                    value={data.jenisIbadah}
                    message={errors.jenisIbadah}
                    handleChange={onHandleChange}
                    listJenis={arrayJenisIbadah()}
                />

                <Kategori
                    name='kategori'
                    value={data.kategori}
                    message={errors.kategori}
                    handleChange={onHandleChange}
                    listKategori={arrayKategoriRole()}
                />

                <JenisKelamin
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
                />
            </div>

            {
                show && (
                    <PrimaryButton onClick={handleNihil} disabled={processing} children='set hadir' />
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
                                            value={user.ibadah_detail?.kehadiran_id ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, user.id, user.name, user.ibadah_detail?.id, user.ibadah_detail.ibadah_id)}
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

InputIbadah.layout = page => <AppLayout children={page} />
export default InputIbadah