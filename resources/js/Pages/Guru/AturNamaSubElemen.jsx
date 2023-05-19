import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import InputText from '@/Components/Sia/InputText'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import Elemen from '@/Components/Sia/Elemen'

const AturNamaSubElemen = ({ listElemen, listSubElemen }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        elemenId: '',
        nama: '',
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('atur-nama-sub-elemen.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Sub Elemen')
                    setData({ ...data })
                },
                onError: (error) => {
                    Sweet.fire({
                        title: 'Gagal!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Kembali'
                    })
                }
            }
        )
    }
    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus dimensi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('atur-nama-sub-elemen.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Sub Elemen')
                                setData({ ...data })
                            }
                        }
                    )
            })
    }

    return (
        <>
            <Head title='Atur Nama Sub Elemen' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">atur nama sub elemen</div>
            <form onSubmit={submit} className='space-y-3 mb-3'>
                <div className='grid grid-cols-3 gap-2'>

                    <Elemen
                        id="elemenId"
                        name="elemenId"
                        value={data.elemenId}
                        message={errors.elemenId}
                        isFocused={true}
                        handleChange={onHandleChange}
                        listElemen={listElemen}
                    />

                    <InputText
                        id="nama"
                        label="nama sub elemen"
                        name="nama"
                        value={data.nama}
                        message={errors.nama}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />
                </div>
                <PrimaryButton onClick={submit} disabled={processing}>Simpan</PrimaryButton>
            </form>
            <div className="overflow-x-auto">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama Dimensi
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama Elemen
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama Sub Elemen
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSubElemen && listSubElemen.map((sub, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {sub.elemen?.dimensi?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {sub.elemen?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {sub.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(sub.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )

}

AturNamaSubElemen.layout = page => <AppLayout children={page} />
export default AturNamaSubElemen
