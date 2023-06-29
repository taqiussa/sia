import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import JamTime from '@/Components/Sia/JamTime'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal, jamTime } from '@/Functions/functions'
import getListAturanPulangAwal from '@/Functions/getListAturanPulangAwal'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const AturPulangAwal = ({ initTahun }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        hari: '',
        pilihan: 'Pulang',
        jam: '',
        listAturan: []
    })

    async function getData() {
        const res = await getListAturanPulangAwal(data.tahun)
        setData({ ...data, listAturan: res.listAturan })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {

        e.preventDefault()

        post(route('atur-pulang-awal.simpan'),

            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Aturan')
                    setData({ ...data })
                    getData()
                }
            }
        )
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Menghapus Aturan',
                text: 'Anda yakin menghapus ?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('atur-pulang-awal.hapus', {
                            id: id,
                        }
                        ),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Aturan')
                                setData({ ...data })
                                getData()
                            }
                        }
                    )
            })

    }

    useEffect(() => {

        if (data.tahun)
            trackPromise(getData())

    }, [data.tahun])

    return (
        <>
            <Head title='Atur Pulang Awal' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 mb-2 uppercase">
                Atur Pulang Awal
            </div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Tanggal
                    name='tanggal'
                    label='tanggal'
                    value={data.tanggal}
                    message={errors.tanggal}
                    handleChange={onHandleChange}
                />

                <div className="flex flex-col text-slate-600 capitalize">
                    <div>
                        pilih
                    </div>
                    <div>
                        <select
                            name='pilihan'
                            id='piihan'
                            value={data.pilihan}
                            className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full text-slate-600'
                            onChange={onHandleChange}
                        >

                            <option value="">Pilih</option>
                            <option value="Pulang">Pulang</option>
                            <option value="Masuk">Masuk</option>

                        </select>
                    </div>
                </div>

                <JamTime
                    id='jam'
                    name='jam'
                    value={data.jam}
                    message={errors.jam}
                    handleChange={onHandleChange}
                />

            </div>

            <PrimaryButton onClick={submit} children='simpan' disabled={processing} />

            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tahun
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Pulang Awal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Masuk Siang
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listAturan && data.listAturan.map((aturan, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {aturan.tahun}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {hariTanggal(aturan.tanggal)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {aturan.pulang ? jamTime(aturan.pulang) : null}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {aturan.masuk ? jamTime(aturan.pulang) : null}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
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

AturPulangAwal.layout = page => <AppLayout children={page} />
export default AturPulangAwal