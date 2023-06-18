import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'
import { QrScanner } from '@yudiel/react-qr-scanner'
import { toast } from 'react-toastify'

const AbsensiKetenagaan = ({ listAbsensi }) => {

    const { data, setData, post, errors, processing } = useForm({
        id: '',
        pilihan: 'Masuk'
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {

        setData({ ...data, id: e })
        post(route('absensi-ketenagaan.simpan'),
            {
                onSuccess: (response) => {
                    toast.success('Berhasil Absen')
                    setData({ ...data, id: '' })
                },
                onError: (response) => {
                    toast.error('Gagal, Ulangi')
                }
            })
    }

    return (
        <>
            <Head title='Absensi Guru dan Karyawan' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 bg-emerald-200">absensi guru dan karyawan</div>
            <div className='lg:grid lg:grid-cols-3 lg:gap-2 lg:space-y-0 py-2'>
                <div>
                    <select
                        name='pilihan'
                        id='piihan'
                        value={data.pilihan}
                        className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full text-slate-600'
                        onChange={onHandleChange}
                    >

                        <option value="">Pilih</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Pulang">Pulang</option>

                    </select>
                </div>
            </div>
            <div className='lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 py-2'>
                <div className='flex items-start justify-start text-center py-2 max-w-md'>
                    <QrScanner
                        onDecode={(e) => submit(e)}
                        onError={(error) => console.log(error?.message)}
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
                                    Nama
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Masuk
                                </th>
                                <th scope='col' className="py-3 px-2 text-left">
                                    Pulang
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {listAbsensi && listAbsensi
                                .map((absensi, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {index + 1}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {absensi.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {absensi.masuk ? new Date(absensi.masuk).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : null}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {absensi.pulang ? new Date(absensi.pulang).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : null}
                                        </td>
                                    </tr>
                                ))}
                        </tbody>
                    </table>
                </div>
            </div>

        </>
    )
}

AbsensiKetenagaan.layout = page => <AppLayout children={page} />
export default AbsensiKetenagaan