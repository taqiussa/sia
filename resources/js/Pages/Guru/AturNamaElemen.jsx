import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import InputText from '@/Components/Sia/InputText'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import Dimensi from '@/Components/Sia/Dimensi'

const AturNamaElemen = ({ listDimensi, listElemen }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        dimensiId: '',
        nama: '',
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('atur-nama-elemen.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Elemen')
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
                        route('atur-nama-elemen.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Elemen')
                                setData({ ...data })
                            }
                        }
                    )
            })
    }

    return (
        <>
            <Head title='Atur Nama Elemen' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">atur nama elemen</div>
            <form onSubmit={submit} className='space-y-3 mb-3'>
                <div className='grid grid-cols-3 gap-2'>

                    <Dimensi
                        id="dimensiId"
                        name="dimensiId"
                        value={data.dimensiId}
                        message={errors.dimensiId}
                        isFocused={true}
                        handleChange={onHandleChange}
                        listDimensi={listDimensi}
                    />

                    <InputText
                        id="nama"
                        label="nama elemen"
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
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listElemen && listElemen.map((elemen, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {elemen.dimensi?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {elemen.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(elemen.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )

}

AturNamaElemen.layout = page => <AppLayout children={page} />
export default AturNamaElemen
