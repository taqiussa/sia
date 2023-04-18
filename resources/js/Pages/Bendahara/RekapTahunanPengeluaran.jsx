import Paginator from '@/Components/Sia/Paginator'
import PrintLink from '@/Components/Sia/PrintLink'
import PrintLinkMerah from '@/Components/Sia/PrintLinkMerah'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, rupiah } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const RekapTahunanPengeluaran = ({ initTahun, listPengeluaran, total }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    useEffect(() => {
        if (data.tahun) {
            router.reload(
                {
                    only: ['listPengeluaran', 'total'],
                    data: {
                        tahun: data.tahun
                    },
                    preserveState: true,
                    replace: true
                },
            )
        }

    }, [data.tahun])

    return (
        <>
            <Head title='Rekap Tahunan Pengeluaran' />
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 space-y-3'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <div className="flex items-end space-x-2">
                    <PrintLink
                        href={route('rekap-tahunan-pengeluaran-simple', {
                            tahun: data.tahun
                        })}
                        label='print'
                    />
                    <PrintLinkMerah
                        href={route('rekap-tahunan-pengeluaran-detail', {
                            tahun: data.tahun
                        })}
                        label='print detail'
                    />
                </div>

            </div>
            <div className="py-3 font-bold text-lg text-slate-600">Rekap pengeluaran</div>
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
                                Bendahara
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listPengeluaran &&
                            listPengeluaran.data.map((list, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1}
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
                                        {list.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {rupiah(list.jumlah)}
                                    </td>
                                </tr>
                            ))}
                        <tr>
                            <td className="py-2 px-2 font-bold text-xl text-slate-600 bg-slate-300" colSpan={5}>
                                Total
                            </td>
                            <td className="py-2 px-2 font-bold text-xl text-slate-600 bg-slate-300">
                                {rupiah(total)}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {
                listPengeluaran.data.length > 0 &&
                <Paginator lists={listPengeluaran} />
            }
        </>
    )
}

RekapTahunanPengeluaran.layout = page => <AppLayout children={page} />
export default RekapTahunanPengeluaran