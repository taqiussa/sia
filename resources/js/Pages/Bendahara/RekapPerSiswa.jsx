import Kelas from '@/Components/Sia/Kelas'
import PrintIcon from '@/Components/Sia/PrintIcon'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const RekapPerSiswa = ({ initTahun, listKelas, listSiswa }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        kelasId: '',
    })


    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    useEffect(() => {
        if (data.tahun && data.kelasId)
            router.reload(
                {
                    only: ['listSiswa'],
                    data: {
                        tahun: data.tahun,
                        kelasId: data.kelasId
                    },
                    preserveState: true,
                    replace: true
                },
            )
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Rekap Per Siswa' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap per siswa</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    label='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
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
                                Nis
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa &&
                            listSiswa.map((list, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.nis}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                        <PrintIcon
                                            href={route('rekap-per-siswa-print', {
                                                tahun: data.tahun,
                                                kelasId: data.kelasId,
                                                nis: list.nis
                                            })}
                                        />

                                    </td>
                                </tr>
                            ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

RekapPerSiswa.layout = page => <AppLayout children={page} />
export default RekapPerSiswa