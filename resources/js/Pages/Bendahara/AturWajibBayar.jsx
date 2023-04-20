import React, { useEffect, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Tingkat from '@/Components/Sia/Tingkat'
import InputText from '@/Components/Sia/InputText'
import { maskRupiah, rupiah } from '@/Functions/functions'
import getWajibBayar from '@/Functions/getWajibBayar'
import { trackPromise } from 'react-promise-tracker'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'

const AturWajibBayar = ({ initTahun }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        tingkat: '',
        jumlah: ''
    })

    const [listWajibBayar, setListWajibBayar] = useState([])

    async function getDataWajibBayar() {
        const response = await getWajibBayar(data.tahun)

        setListWajibBayar(response.listWajibBayar)
    }


    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleRupiah = (event) => {
        const value = event.target.value
        setData('jumlah', maskRupiah(value))
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('atur-wajib-bayar.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Wajib Bayar')
                    setData({
                        tahun: data.tahun,
                        tingkat: data.tingkat,
                        jumlah: data.jumlah
                    })
                    getDataWajibBayar()
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
                text: "Hapus Wajib Bayar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('atur-wajib-bayar.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Wajib Bayar')
                                setData({
                                    tahun: data.tahun,
                                    tingkat: data.tingkat,
                                    jumlah: data.jumlah
                                })
                                getDataWajibBayar()
                            }
                        }
                    )
            })
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getDataWajibBayar()
            )
    }, [])

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getDataWajibBayar()
            )
        return () => {
            setListWajibBayar([])
        }
    }, [data.tahun])

    return (
        <>
            <Head title='Atur Wajib Bayar' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">atur wajib bayar</div>
            <form onSubmit={submit} className='space-y-3 mb-3'>
                <div className='grid grid-cols-3 gap-2'>
                    <Tahun
                        id='tahun'
                        name='tahun'
                        value={data.tahun}
                        message={errors.tahun}
                        handleChange={onHandleChange}
                    />

                    <Tingkat
                        id='tingkat'
                        name='tingkat'
                        value={data.tingkat}
                        message={errors.tingkat}
                        handleChange={onHandleChange}
                    />

                    <InputText
                        id="jumlah"
                        label="Jumlah"
                        name="jumlah"
                        value={data.jumlah}
                        message={errors.jumlah}
                        isFocused={true}
                        handleChange={handleRupiah}
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
                                Tahun
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tingkat
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jumlah
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listWajibBayar && listWajibBayar.map((wajib, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {wajib.tahun}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {wajib.tingkat}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {rupiah(wajib.jumlah)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(wajib.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )

}

AturWajibBayar.layout = page => <AppLayout children={page} />
export default AturWajibBayar
