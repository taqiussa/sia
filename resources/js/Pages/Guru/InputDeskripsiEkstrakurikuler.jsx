import PrimaryButton from '@/Components/PrimaryButton'
import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getListEkstrakurikuler from '@/Functions/getListEkstrakurikuler'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputDeskripsiEkstrakurikuler = ({ initTahun, initSemester }) => {

    const { data, setData, errors, processing, post, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        ekstrakurikulerId: '',
        deskripsi: '',
        listEkstrakurikuler: []
    })

    async function getData() {
        const response = await getListEkstrakurikuler(data.tahun, data.semester)
        setData({ ...data, listEkstrakurikuler: response.listEkstrakurikuler })
    }
    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-deskripsi-ekstrakurikuler.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Deskripsi Ekstrakurikuler')
                setData({ ...data })
                trackPromise(getData())
            }
        })
    }

    const handleDelete = (id) => {

        Sweet.
            fire({
                title: 'Menghapus Deskripsi',
                text: 'Anda Yakin Menghapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('input-deskripsi-ekstrakurikuler.hapus', {
                            id: id,
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Deskripsi Ekstrakurikuler')
                                setData({...data})
                                trackPromise(getData())
                            }
                        }
                    )
            })
    }

    useEffect(() => {

        if (data.tahun && data.semester)
            trackPromise(getData())

    }, [])

    useEffect(() => {

        if (data.tahun && data.semester)
            trackPromise(getData())

    }, [data.tahun, data.semester])

    return (
        <>
            <Head title='Input Deskripsi Ekstrakurikuler' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input deskripsi ekstrakurikuler</div>
            <form onSubmit={submit} className='space-y-3'>
                <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                    <Tahun
                        id='tahun'
                        name='tahun'
                        value={data.tahun}
                        message={errors.tahun}
                        handleChange={onHandleChange}
                    />

                    <Semester
                        id='semester'
                        name='semester'
                        value={data.semester}
                        message={errors.semester}
                        handleChange={onHandleChange}
                    />

                    <div className="col-span-2 lg:col-span-1">

                        <Ekstrakurikuler
                            id='ekstrakurikulerId'
                            name='ekstrakurikulerId'
                            value={data.ekstrakurikulerId}
                            message={errors.ekstrakurikulerId}
                            handleChange={onHandleChange}
                            listEkstrakurikuler={data.listEkstrakurikuler}
                        />

                    </div>
                </div>

                <InputArea
                    id='deskripsi'
                    name='deskripsi'
                    label='KD / deskripsi ekstrakurikuler'
                    rows={3}
                    value={data.deskripsi}
                    message={errors.deskripsi}
                    handleChange={onHandleChange}
                />

                <PrimaryButton onClick={submit} children='simpan' disabled={processing} />
            </form>
            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama Ekstra
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Deskripsi
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listEkstrakurikuler && data.listEkstrakurikuler.map((ekstra, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {ekstra.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {ekstra.deskripsi?.deskripsi}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {
                                        ekstra.deskripsi.id &&
                                        <Hapus onClick={() => handleDelete(ekstra.deskripsi?.id)} />
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

InputDeskripsiEkstrakurikuler.layout = page => <AppLayout children={page} />
export default InputDeskripsiEkstrakurikuler