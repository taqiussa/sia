import Guru from '@/Components/Sia/Guru'
import Tanggal from '@/Components/Sia/Tanggal'
import getPermintaanBadal from '@/Functions/getPermintaanBadal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import moment from 'moment/moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const PermintaanBadal = () => {

    const { data, setData, errors, post, processing } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        userId: ''
    })

    const [listPermintaan, setListPermintaan] = useState([])
    const [listUser, setListUser] = useState([])

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataPermintaan() {
        const response = await getPermintaanBadal(data.tanggal)
        setListPermintaan(response.listPermintaan)
    }

    useEffect(() => {
        if (data.tanggal)
            trackPromise(
                getDataPermintaan()
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
                                    <Guru
                                        id='userId'
                                        name='userId'
                                        value={data.userId}
                                        handleChange={onHandleChange}
                                        message={errors.userId}
                                        listUser={listUser}
                                    />
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
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