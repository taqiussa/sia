import PrimaryButton from '@/Components/PrimaryButton'
import RadioButton from '@/Components/RadioButton'
import Guru from '@/Components/Sia/Guru'
import Sweet from '@/Components/Sia/Sweet'
import Tanggal from '@/Components/Sia/Tanggal'
import getGuruIzin from '@/Functions/getGuruIzin'
import getGuruKosong from '@/Functions/getGuruKosong'
import getGuruSudahBadal from '@/Functions/getGuruSudahBadal'
import getPermintaanBadal from '@/Functions/getPermintaanBadal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment/moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const PermintaanBadal = ({ listGuruAlquran, listGuruBk }) => {

    const { data, setData, errors, post, processing } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        userId: ''
    })

    const [listPermintaan, setListPermintaan] = useState([])
    const [listGuruIzin, setListGuruIzin] = useState([])
    const [listUser, setListUser] = useState([])
    const [listGuruKosong, setListGuruKosong] = useState([])
    const [listGuruSudahBadal, setListGuruSudahBadal] = useState([])


    const [selectedRadio, setSelectedRadio] = useState('');

    const handleRadioChange = (event) => {
        setSelectedRadio(event.target.value);
    };

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataPermintaan() {
        const response = await getPermintaanBadal(data.tanggal)
        setListPermintaan(response.listPermintaan)
    }

    async function getDataGuruIzin() {
        const response = await getGuruIzin(data.tanggal)
        setListGuruIzin(response.listGuruIzin)
    }

    async function getDataGuruKosong() {
        const response = await getGuruKosong(data.tanggal)
        setListGuruKosong(response.listGuruKosong)
    }

    async function getDataGuruSudahBadal() {
        const response = await getGuruSudahBadal(data.tanggal)
        setListGuruSudahBadal(response.listGuruSudahBadal)
    }

    const submit = (e, id) => {
        e.preventDefault()

        post(
            route('permintaan-badal.simpan',
                {
                    id: id,
                    badalId: data.userId
                }),
            {
                onSuccess: () => {
                    toast.success('Berhasil Membuat Badal')
                    setData({
                        tanggal: data.tanggal,
                        userId: ''
                    })
                    getDataPermintaan()
                },
                onError: () => {
                    Sweet.fire({
                        title: 'Oops....',
                        text: 'Guru Badal Belum di Pilih',
                        icon: 'error'
                    })
                }
            })
    }

    useEffect(() => {
        let filteredUser = [];

        if (selectedRadio === 'bk') {
            filteredUser = listGuruBk
        } else if (selectedRadio === 'kosong') {
            filteredUser = listGuruKosong
        } else if (selectedRadio === 'alquran') {
            filteredUser = listGuruAlquran
        }

        setListUser(filteredUser)

    }, [selectedRadio])

    useEffect(() => {
        if (data.tanggal)
            trackPromise(
                getDataPermintaan(),
                getDataGuruIzin(),
                getDataGuruKosong(),
                getDataGuruSudahBadal()
            )
    }, [data.tanggal])
    return (
        <>
            <Head title='Permintaan Badal' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">permintaan badal</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    message={errors.tanggal}
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
                                Guru Izin
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Mata pelajaran
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Guru Badal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listPermintaan && listPermintaan.map((permintaan, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {permintaan.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {permintaan.jam}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {permintaan.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {permintaan.mapel?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className="flex flex-col">

                                        <Guru
                                            id='userId'
                                            name='userId'
                                            value={data.userId}
                                            handleChange={onHandleChange}
                                            message={errors.userId}
                                            listUser={listUser.filter((user) => {
                                                if (!user.jam_kosong) {
                                                    return !listGuruSudahBadal.some((sudahBadal) => sudahBadal.jam === permintaan.jam && sudahBadal.badal_id === user.id)
                                                } else {
                                                    const filteredKosong = user.jam_kosong.filter((kosong) => {
                                                        return kosong.jam === permintaan.jam
                                                            && !listGuruIzin.includes(kosong.user_id)
                                                            && !listGuruSudahBadal.some((sudahBadal) => sudahBadal.jam === permintaan.jam && sudahBadal.badal_id === kosong.user_id)
                                                    })
                                                    return filteredKosong.length > 0
                                                }
                                            })}
                                        />

                                        <RadioButton
                                            name='radio'
                                            value='kosong'
                                            label='guru kosong'
                                            handleChange={handleRadioChange}
                                            checked={selectedRadio === 'kosong'}
                                        />

                                        <RadioButton
                                            name='radio'
                                            value='bk'
                                            label='guru bk'
                                            handleChange={handleRadioChange}
                                            checked={selectedRadio === 'bk'}
                                        />


                                        <RadioButton
                                            name='radio'
                                            value='alquran'
                                            label="guru al qur'an"
                                            handleChange={handleRadioChange}
                                            checked={selectedRadio === 'alquran'}
                                        />
                                    </div>
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <PrimaryButton children='simpan' onClick={(e) => submit(e, permintaan.id)} disabled={processing} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}
PermintaanBadal.layout = page => <AppLayout children={page} />
export default PermintaanBadal