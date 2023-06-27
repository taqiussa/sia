import InputText from '@/Components/Sia/InputText'
import Tanggal from '@/Components/Sia/Tanggal'
import getAbsensiHarianKaryawan from '@/Functions/getAbsensiHarianKaryawan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment/moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const RekapHarianAbsensiKaryawan = () => {

    const { data, setData } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        search: ''
    })

    const [listAbsensi, setListAbsensi] = useState([])

    const filteredData = listAbsensi?.filter((list) => {
        const searchTerm = data.search.toLowerCase();
        const user = list.user?.name?.toLowerCase();

        return (
            (user && user.includes(searchTerm))// Filter by name
        );
    });

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataAbsensi() {
        const res = await getAbsensiHarianKaryawan(data.tanggal)
        setListAbsensi(res.listAbsensi)
    }

    useEffect(() => {
        if (data.tanggal)
            trackPromise(getDataAbsensi())
    }, [data.tanggal])

    return (
        <>
            <Head title='Rekap Harian Absensi' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 bg-emerald-200">rekap harian absensi karyawan</div>
            <div className='lg:grid lg:grid-cols-3 lg:gap-2 lg:space-y-0 py-2'>
                <Tanggal
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    handleChange={onHandleChange}
                />

                <InputText
                    id='search'
                    name='search'
                    value={data.search}
                    label='search'
                    handleChange={onHandleChange}
                />

            </div>
            <div className="overflow-x-auto">
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
                                Masuk
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Pulang
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listAbsensi && filteredData
                            .map((absensi, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {index + 1}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {absensi.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {absensi.masuk ? new Date(absensi.masuk).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : null}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {absensi.pulang ? new Date(absensi.pulang).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : null}
                                    </td>
                                </tr>
                            ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

RekapHarianAbsensiKaryawan.layout = page => <AppLayout children={page} />
export default RekapHarianAbsensiKaryawan