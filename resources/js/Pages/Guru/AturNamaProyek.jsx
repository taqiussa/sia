import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import InputText from '@/Components/Sia/InputText'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'

const AturNamaProyek = ({ listProyek }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        nama: '',
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('atur-nama-proyek.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Proyek')
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
                text: "Hapus Proyek!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('atur-nama-proyek.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Proyek')
                                setData({ ...data })
                            }
                        }
                    )
            })
    }

    return (
        <>
            <Head title='Atur Nama Proyek' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">atur nama Proyek</div>
            <form onSubmit={submit} className='space-y-3 mb-3'>
                <div className='grid grid-cols-3 gap-2'>
                    <InputText
                        id="nama"
                        label="nama proyek"
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
                                Nama Proyek
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listProyek && listProyek.map((proyek, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {proyek.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(proyek.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )

}

AturNamaProyek.layout = page => <AppLayout children={page} />
export default AturNamaProyek
