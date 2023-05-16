import Kelas from '@/Components/Sia/Kelas'
import Tahun from '@/Components/Sia/Tahun'
import getSiswaWithBiodata from '@/Functions/getSiswaWithBiodata'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const BiodataSiswa = ({ initTahun, listKelas }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        kelasId: '',
        listSiswa: []
    })

    async function getData() {
        const response = await getSiswaWithBiodata(data.tahun, data.kelasId)
        setData({ ...data, listSiswa: response.listSiswa })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {
        if (data.tahun && data.kelasId)
            trackPromise(getData())
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Bioadata Siswa' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">biodata siswa</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    listKelas={listKelas}
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
                                NIS
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Ayah
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Ibu
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Desa
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kontak
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listSiswa && data.listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.nis}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.orang_tua?.nama_ayah}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.orang_tua?.nama_ibu}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.alamat?.desa}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.biodata?.telepon}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

BiodataSiswa.layout = page => <AppLayout children={page} />
export default BiodataSiswa