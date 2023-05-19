import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import InputText from '@/Components/Sia/InputText'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import Elemen from '@/Components/Sia/Elemen'
import getListElemen from '@/Functions/getListElemen'
import getListSubElemen from '@/Functions/getListSubElemen'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import getListAturanProyek from '@/Functions/getListAturanProyek'
import Tahun from '@/Components/Sia/Tahun'
import Proyek from '@/Components/Sia/Proyek'
import Dimensi from '@/Components/Sia/Dimensi'
import SubElemen from '@/Components/Sia/SubElemen'
import InputArea from '@/Components/Sia/InputArea'

const AturPenilaianProyek = ({ initTahun, listProyek, listDimensi }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        proyekId: '',
        dimensiId: '',
        elemenId: '',
        subElemenId: '',
        judul: '',
        capaian: '',
        listElemen: [],
        listSubElemen: [],
        listAturanProyek: []
    })

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    async function getData() {
        const response = await getListAturanProyek(data.tahun)
        setData({ ...data, listAturanProyek: response.listAturanProyek })
    }

    async function getDataElemen() {
        const response = await getListElemen(data.dimensiId)
        setData({ ...data, listElemen: response.listElemen })
    }

    async function getDataSubElemen() {
        const response = await getListSubElemen(data.elemenId)
        setData({ ...data, listSubElemen: response.listSubElemen })
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('atur-penilaian-proyek.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Penilaian Proyek')
                    setData({ ...data })
                    getData()
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
                        route('atur-penilaian-proyek.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Penilaian Proyek')
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

    useEffect(() => {
        if (data.dimensiId)
            trackPromise(getDataElemen())
    }, [data.dimensiId])

    useEffect(() => {
        if (data.elemenId)
            trackPromise(getDataSubElemen())
    }, [data.elemenId])

    return (
        <>
            <Head title='Atur Nama Sub Elemen' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">atur nama sub elemen</div>
            <form onSubmit={submit} className='space-y-3 mb-3'>
                <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>

                    <Tahun
                        id="tahun"
                        name="tahun"
                        value={data.tahun}
                        message={errors.tahun}
                        isFocused={true}
                        handleChange={onHandleChange}
                    />

                    <Proyek
                        id="proyekId"
                        name="proyekId"
                        value={data.proyekId}
                        message={errors.proyekId}
                        isFocused={true}
                        handleChange={onHandleChange}
                        listProyek={listProyek}
                    />

                    <Dimensi
                        id="dimensiId"
                        name="dimensiId"
                        value={data.dimensiId}
                        message={errors.dimensiId}
                        isFocused={true}
                        handleChange={onHandleChange}
                        listDimensi={listDimensi}
                    />

                    <Elemen
                        id="elemenId"
                        name="elemenId"
                        value={data.elemenId}
                        message={errors.elemenId}
                        isFocused={true}
                        handleChange={onHandleChange}
                        listElemen={data.listElemen}
                    />

                    <SubElemen
                        id="subElemenId"
                        name="subElemenId"
                        value={data.subElemenId}
                        message={errors.subElemenId}
                        isFocused={true}
                        handleChange={onHandleChange}
                        listSubElemen={data.listSubElemen}
                    />

                </div>

                <InputText
                    id="judul"
                    label="judul"
                    name="judul"
                    value={data.judul}
                    message={errors.judul}
                    isFocused={true}
                    handleChange={onHandleChange}
                />

                <InputArea
                    id="capaian"
                    label="capaian"
                    name="capaian"
                    value={data.capaian}
                    message={errors.capaian}
                    isFocused={true}
                    handleChange={onHandleChange}
                />
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
                                Judul Proyek
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
                                Capaian
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listAturanProyek && data.listAturanProyek.map((atur, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {atur.proyek?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {atur.judul}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {atur.dimensi?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {atur.elemen?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {atur.subElemen?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {atur.capaian}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(atur.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )

}

AturPenilaianProyek.layout = page => <AppLayout children={page} />
export default AturPenilaianProyek
