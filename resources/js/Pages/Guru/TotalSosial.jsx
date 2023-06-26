import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Kategori from '@/Components/Sia/Kategori'
import Tahun from '@/Components/Sia/Tahun'
import { arrayKategoriRole } from '@/Functions/functions'
import getAbsensiSosials from '@/Functions/getAbsensiSosials'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'
import { useEffect } from 'react'
import { useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const TotalSosial = ({ initTahun }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        role: '',
        jenisKelamin: ''
    })

    const [listUser, setListUser] = useState([])

    async function getDataAbsensi() {
        const res = await getAbsensiSosials(data.tahun, data.role, data.jenisKelamin)
        setListUser(res.listUser)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }
    useEffect(() => {
        if (data.tahun
            && data.role
            && data.jenisKelamin
        )
            trackPromise(
                getDataAbsensi()
            )
    }, [data.tahun, data.role, data.jenisKelamin])

    return (
        <>
            <Head title='Total Sosial' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">total sosial</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <Kategori
                    name='role'
                    value={data.role}
                    handleChange={onHandleChange}
                    listKategori={arrayKategoriRole()}
                />

                <JenisKelamin
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    handleChange={onHandleChange}
                />

            </div>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th rowSpan={2} scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th rowSpan={2} scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th colSpan={3} scope='col' className="py-3 px-2">
                                Total Kehadiran
                            </th>
                            <th rowSpan={2} scope='col' className="py-3 px-2">
                                Total
                            </th>
                        </tr>
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                H
                            </th>
                            <th scope='col' className="py-3 px-2">
                                I
                            </th>
                            <th scope='col' className="py-3 px-2">
                                A
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
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {
                                        user.sosial_details.filter(sosial => sosial.kehadiran_id == 1).length
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {
                                        user.sosial_details.filter(sosial => sosial.kehadiran_id == 2).length
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {
                                        user.sosial_details.filter(sosial => sosial.kehadiran_id == 3).length
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {
                                        user.sosial_details.length
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

TotalSosial.layout = page => <AppLayout children={page} />
export default TotalSosial