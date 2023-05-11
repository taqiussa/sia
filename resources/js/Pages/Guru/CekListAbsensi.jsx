import Tanggal from '@/Components/Sia/Tanggal'
import getAbsensiKelas from '@/Functions/getAbsensiKelas'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import { mdiCheckCircle } from '@mdi/js'
import { Icon } from '@mdi/react'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'

const CekListAbsensi = () => {

    const { data, setData } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD')
    })

    const [listKelas, setListKelas] = useState([])

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getDataListKelas() {
        const response = await getAbsensiKelas(data.tanggal)
        setListKelas(response.listKelas)
    }

    useEffect(() => {
        if (data.tanggal)
            trackPromise(
                getDataListKelas()
            )
    }, [data.tanggal])
    return (
        <>
            <Head title='Cek List Absensi' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 upperacase mb-2">
                cek list absensi kelas
            </div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>

                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    value={data.tanggal}
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
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam 1-2
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam 3-4
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam 5-6
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam 7-8
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listKelas && listKelas.map((kelas, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.absensis.filter(absensi => absensi.jam == '1-2').length > 0 &&
                                        <Icon path={mdiCheckCircle} size={1} className='text-emerald-500' />
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.absensis.filter(absensi => absensi.jam == '3-4').length > 0 &&
                                        <Icon path={mdiCheckCircle} size={1} className='text-emerald-500' />
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.absensis.filter(absensi => absensi.jam == '5-6').length > 0 &&
                                        <Icon path={mdiCheckCircle} size={1} className='text-emerald-500' />
                                    }
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {kelas.absensis.filter(absensi => absensi.jam == '7-8').length > 0 &&
                                        <Icon path={mdiCheckCircle} size={1} className='text-emerald-500' />
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

CekListAbsensi.layout = page => <AppLayout children={page} />
export default CekListAbsensi