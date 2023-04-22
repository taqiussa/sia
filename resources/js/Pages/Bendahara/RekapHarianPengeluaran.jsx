import DownloadLink from '@/Components/Sia/DownloadLink'
import Paginator from '@/Components/Sia/Paginator'
import PrintLink from '@/Components/Sia/PrintLink'
import PrintLinkMerah from '@/Components/Sia/PrintLinkMerah'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal, rupiah, tanggal } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect } from 'react'

const RekapHarianPengeluaran = ({ initTahun, listPengeluaran, total }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        tanggalAwal: moment(new Date()).format('YYYY-MM-DD'),
        tanggalAkhir: moment(new Date()).format('YYYY-MM-DD'),
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    useEffect(() => {
        const timerId = setTimeout(() => {
            router.reload(
                {
                    only: ['listPengeluaran', 'total'],
                    data: {
                        tanggalAwal: data.tanggalAwal,
                        tanggalAkhir: data.tanggalAkhir,
                    },
                    preserveState: true,
                    replace: true
                },
            )
        }, 1000)

        return () => {
            clearTimeout(timerId)
        }

    }, [data.tanggalAwal, data.tanggalAkhir])

    return (
        <>
            <Head title='Rekap Harian Pengeluaran' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap harian pengeluaran</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 space-y-3'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    messages={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    id='tanggalAwal'
                    name='tanggalAwal'
                    label='tanggal awal'
                    value={data.tanggalAwal}
                    messages={errors.tanggalAwal}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    id='tanggalAkhir'
                    name='tanggalAkhir'
                    label='tanggal akhir'
                    value={data.tanggalAkhir}
                    messages={errors.tanggalAkhir}
                    handleChange={onHandleChange}
                />

                <div className="flex items-end space-x-2">
                    <DownloadLink
                        href={route('rekap-harian-pengeluaran-download', {
                            tahun: data.tahun,
                            tanggalAwal: data.tanggalAwal,
                            tanggalAkhir: data.tanggalAkhir
                        })}
                        label='download'
                    />
                    <PrintLink
                        href={route('rekap-harian-pengeluaran-simple', {
                            tahun: data.tahun,
                            tanggalAwal: data.tanggalAwal,
                            tanggalAkhir: data.tanggalAkhir
                        })}
                        label='print'
                    />
                    <PrintLinkMerah
                        href={route('rekap-harian-pengeluaran-detail', {
                            tahun: data.tahun,
                            tanggalAwal: data.tanggalAwal,
                            tanggalAkhir: data.tanggalAkhir
                        })}
                        label='print detail'
                    />
                </div>

            </div>
            <div className="py-3 font-bold text-lg text-slate-600">Rekap Pengeluaran</div>
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
                                Tanggal Nota
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
                                        {tanggal(list.tanggal_nota)}
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
                            <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-200" colSpan={6}>
                                Total
                            </td>
                            <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-200">
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

RekapHarianPengeluaran.layout = page => <AppLayout children={page} />
export default RekapHarianPengeluaran