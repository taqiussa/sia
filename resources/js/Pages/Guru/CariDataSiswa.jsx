import InputText from '@/Components/Sia/InputText'
import Paginator from '@/Components/Sia/Paginator'
import Tahun from '@/Components/Sia/Tahun'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const CariDataSiswa = ({ initTahun, listSiswa, filters }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        search: filters.search ?? ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {
        if (data.tahun)
            router.reload({
                only: ['listSiswa'],
                data: {
                    tahun: data.tahun
                },
                replace: true,
                preserveState: true
            })
    }, [data.tahun])

    useEffect(() => {
        const timerId = setTimeout(() => {
            router.reload(
                {
                    only: ['listSiswa'],
                    data: {
                        tahun: data.tahun,
                        search: data.search
                    },
                    preserveState: true,
                    replace: true
                },
            )
        }, 1000)

        return () => {
            clearTimeout(timerId)
        }
    }, [data.search])

    return (
        <>
            <Head title='Cari Data Siswa' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">cari data siswa</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
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
                                NIS
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                NISN
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Orang Tua
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Alamat
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa &&
                            listSiswa.data.map((siswa, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1 + ((listSiswa.current_page - 1) * listSiswa.per_page)}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.nis}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.biodata?.nisn}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.kelas?.nama}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.orangTua?.nama_ayah}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        RT {siswa.alamat?.rt} RW {siswa.alamat?.rw}, Desa {siswa.alamat?.desa} - Kec. {siswa.alamat?.kecamatan}
                                    </td>
                                </tr>
                            ))}
                    </tbody>
                </table>
            </div>
            <Paginator lists={listSiswa} />
        </>
    )
}

CariDataSiswa.layout = page => <AppLayout children={page} />
export default CariDataSiswa