import React from 'react'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import { useState } from 'react'
import getAturanKhususPulang from '@/Functions/getAturanKhususPulang'
import { toast } from 'react-toastify'
import { trackPromise } from 'react-promise-tracker'
import Sweet from '@/Components/Sia/Sweet'
import { useEffect } from 'react'
import Tahun from '@/Components/Sia/Tahun'
import Guru from '@/Components/Sia/Guru'
import Hari from '@/Components/Sia/Hari'
import PrimaryButton from '@/Components/PrimaryButton'
import JamTime from '@/Components/Sia/JamTime'
import Hapus from '@/Components/Sia/Hapus'
import { jamTime, namaHari } from '@/Functions/functions'

const AturKhususPulang = ({ initTahun, listUser }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        user_id: '',
        hari: '',
        jam: '',
    })

    const [listAturan, setListAturan] = useState([])

    async function getAturan() {
        const res = await getAturanKhususPulang(data.tahun)
        setListAturan(res.listAturan)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('atur-khusus-pulang.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan')
                    setData({ ...data })
                    trackPromise(getAturan())
                }
            })
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Hapus Data',
                text: 'Yakin Menghapus Data?',
                icon: 'question',
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus!'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(route('atur-khusus-pulang', { id: id }), {
                        onSuccess: () => {
                            toast.success('Berhasil Hapus')
                            setData({ ...data })
                            trackPromise(getAturan())
                        }
                    })
            })
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(getAturan())
    }, [data.tahun])

    return (
        <>
            <Head title='Atur Pulang Khusus' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">atur pulang khusus</div>
            <form onSubmit={submit}>

                <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                    <Tahun
                        name='tahun'
                        value={data.tahun}
                        message={errors.tahun}
                        handleChange={onHandleChange}
                    />

                    <Guru
                        name='user_id'
                        value={data.user_id}
                        message={errors.user_id}
                        handleChange={onHandleChange}
                        listUser={listUser}
                    />

                    <Hari
                        name='hari'
                        value={data.hari}
                        message={errors.hari}
                        handleChange={onHandleChange}
                    />

                    <JamTime
                        name='jam'
                        value={data.jam}
                        message={errors.jam}
                        handleChange={onHandleChange}
                    />
                </div>

                <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
            </form>
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
                                Hari
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listAturan && listAturan.map((aturan, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {aturan.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {namaHari(aturan.hari)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {jamTime(aturan.jam)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">``
                                    <Hapus onClick={() => handleDelete(aturan.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

AturKhususPulang.layout = page => <AppLayout children={page} />
export default AturKhususPulang