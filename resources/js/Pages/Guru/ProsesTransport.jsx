import PrimaryButton from '@/Components/PrimaryButton'
import Bulan from '@/Components/Sia/Bulan'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { toast } from 'react-toastify'

const ProsesTransport = ({ initTahun }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        pilihan: 'Guru',
        bulan: moment(new Date()).format('MM'),
        tanggalAwal: moment(new Date()).format('YYYY-MM-DD'),
        tanggalAkhir: moment(new Date()).format('YYYY-MM-DD')
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('proses-transport.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan')
                },
            })
    }

    return (
        <>
            <Head title='Proses Transport' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-2">proses transport</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    name='bulan'
                    value={data.bulan}
                    message={errors.bulan}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    name='tanggalAwal'
                    label='tanggal Mulai'
                    value={data.tanggalAwal}
                    message={errors.tanggalAwal}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    name='tanggalAkhir'
                    label='tanggal Akhir'
                    value={data.tanggalAkhir}
                    message={errors.tanggalAkhir}
                    handleChange={onHandleChange}
                />

                <div className='flex flex-col text-slate-600'>
                    <div>
                        Pilihan
                    </div>
                    <div>

                        <select
                            name='pilihan'
                            value={data.pilihan}
                            className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full text-slate-600'
                            onChange={onHandleChange}
                        >

                            <option value="">Pilih</option>
                            <option value="Guru">Guru</option>
                            <option value="Satpam">Satpam</option>

                        </select>
                    </div>
                </div>

            </div>
            <div className="py-3">
                <PrimaryButton children='proses' disabled={processing} onClick={submit} />
            </div>
            {/* <div className="overflow-x-auto pt-2">
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
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listUser && listUser.map((user, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {user.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <PrimaryButton children='simpan' disabled={processing} onClick={(e) => submit(e, user.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div> */}
        </>
    )
}

ProsesTransport.layout = page => <AppLayout children={page} />
export default ProsesTransport