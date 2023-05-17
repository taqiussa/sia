import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Paginator from '@/Components/Sia/Paginator'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { toast } from 'react-toastify'

const RekapSkor = ({ initTahun, listRekapSkor }) => {

    const { data, setData, errors, delete: destroy } = useForm({
        tahun: initTahun,
        search: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda Yakin Menghapus ?',
                text: 'Hapus Skor',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(
                        route('rekap-skor.hapus', {
                            id: id,
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Skor')
                                setData({
                                    tahun: data.tahun,
                                    search: data.search
                                })
                                router.reload({
                                    only: ['listRekapSkor'],
                                    data: {
                                        tahun: data.tahun,
                                        search: data.search
                                    },
                                    replace: true,
                                    preserveState: true
                                })
                            }
                        }
                    )
                }
            })
    }

    useEffect(() => {

        if (data.tahun) {
            router.reload({
                only: ['listRekapSkor'],
                data: {
                    tahun: data.tahun,
                    search: data.search
                },
                replace: true,
                preserveState: true
            })
        }
    }, [data.tahun])

    useEffect(() => {

        const timerId = setTimeout(() => {
            router.reload(
                {
                    only: ['listRekapSkor'],
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
            <Head title='Rekap Skor' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap skor</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    label='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <InputText
                    id='search'
                    name='search'
                    value={data.search}
                    message={errors.search}
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
                                Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Keterangan
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Skor
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Guru
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listRekapSkor &&
                            listRekapSkor.data
                                .map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1 + ((listRekapSkor.current_page - 1) * listRekapSkor.per_page)}

                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {hariTanggal(list.tanggal)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.siswa?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.skors?.keterangan}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.skor}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                            <Hapus
                                                onClick={() => handleDelete(list.id)}
                                            />
                                        </td>
                                    </tr>
                                ))}
                    </tbody>
                </table>
            </div>
            <Paginator lists={listRekapSkor} />
        </>
    )
}

RekapSkor.layout = page => <AppLayout children={page} />
export default RekapSkor