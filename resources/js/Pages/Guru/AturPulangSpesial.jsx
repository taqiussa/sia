import PrimaryButton from '@/Components/PrimaryButton'
import Guru from '@/Components/Sia/Guru'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import JamDateTime from '@/Components/Sia/JamDateTime'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal, jamDate } from '@/Functions/functions'
import getListAturanPulangAwal from '@/Functions/getListAturanPulangAwal'
import getListAturanPulangSpesial from '@/Functions/getListAturanPulangSpesial'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const AturPulangSpesial = ({ initTahun, listUser }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        user_id: '',
        keterangan: '',
        listSpesial: []
    })

    async function getData() {
        const res = await getListAturanPulangSpesial(data.tahun)
        setData({ ...data, listSpesial: res.listSpesial })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {

        e.preventDefault()

        post(route('atur-pulang-spesial.simpan'),

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
                        route('atur-pulang-spesial.hapus', {
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
            <Head title='Atur Pulang Spesial' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 mb-2 uppercase">
                Atur Pulang Spesial
            </div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                <Guru
                    name='user_id'
                    value={data.user_id}
                    message={errors.user_id}
                    handleChange={onHandleChange}
                    listUser={listUser}
                />

            </div>

            <InputArea
                label='keterangan'
                name='keterangan'
                value={data.keterangan}
                message={errors.keterangan}
                handleChange={onHandleChange}
            />

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
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listSpesial && data.listSpesial.map((aturan, index) => (
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
                                    {aturan.user?.name}
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

AturPulangSpesial.layout = page => <AppLayout children={page} />
export default AturPulangSpesial