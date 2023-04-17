import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Paginator from '@/Components/Sia/Paginator'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, rupiah } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { toast } from 'react-toastify'

const DataPengeluaran = ({ initTahun, listPengeluaran, filters }) => {

    const { data, setData, errors, delete: destroy } = useForm({
        tahun: initTahun,
        cari: filters.search ?? ''
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda Yakin Menghapus ?',
                text: 'Hapus pengeluaran',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(
                        route('input-pengeluaran.hapus', {
                            id: id,
                            route: 'data-pengeluaran'
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus pengeluaran')
                                setData({
                                    tahun: data.tahun,
                                    search: data.search
                                })
                            }
                        }
                    )
                }
            })
    }

    useEffect(() => {
        if (data.tahun)
            router.reload(
                {
                    only: ['listPengeluaran'],
                    data: {
                        tahun: data.tahun
                    },
                    preserveState: true,
                    replace: true
                },
            )
    }, [data.tahun])

    useEffect(() => {
        const timerId = setTimeout(() => {
            router.reload(
                {
                    only: ['listPengeluaran'],
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
            <Head title='Data Pengeluaran' />
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3'>

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
                                Kategori
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Keterangan
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jumlah
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Bendahara
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listPengeluaran &&
                            listPengeluaran.data.map((list, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1 + ((listPengeluaran.current_page - 1) * listPengeluaran.per_page)}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {hariTanggal(list.tanggal)}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.kategori?.nama}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.keterangan}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {rupiah(list.jumlah)}
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
            <Paginator lists={listPengeluaran} />
        </>
    )
}

DataPengeluaran.layout = page => <AppLayout children={page} />
export default DataPengeluaran