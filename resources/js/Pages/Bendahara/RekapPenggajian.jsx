import Bulan from '@/Components/Sia/Bulan'
import Paginator from '@/Components/Sia/Paginator'
import Tahun from '@/Components/Sia/Tahun'
import { rupiah } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import { toInteger } from 'lodash'
import moment from 'moment'
import React, { useEffect } from 'react'

const RekapPenggajian = ({ initTahun, listPenggajian, total }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM')
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.bulan) {
            router.reload(
                {
                    only: ['listPenggajian', 'total'],
                    data: {
                        tahun: data.tahun,
                        bulan: data.bulan
                    },
                    preserveState: true,
                    replace: true
                }
            )
        }

    }, [data.tahun, data.bulan])
    return (
        <>
            <Head title='Rekap Penggajian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap penggajian</div>

            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-2'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    id='bulan'
                    name='bulan'
                    value={data.bulan}
                    message={errors.bulan}
                    handleChange={onHandleChange}
                />

            </div>
            <div className='overflow-x-auto space-y-7'>
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
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listPenggajian &&
                            listPenggajian.data?.map((list, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + ((toInteger(listPenggajian.current_page - 1) * toInteger(listPenggajian.per_page)) + 1)}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {rupiah(list.penggajian?.jumlah_terima)}
                                    </td>
                                </tr>
                            ))}
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300 capitalize" colSpan={2}>
                                total
                            </td>
                            <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                {rupiah(total)}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginator lists={listPenggajian} />
        </>
    )
}

RekapPenggajian.layout = page => <AppLayout children={page} />
export default RekapPenggajian