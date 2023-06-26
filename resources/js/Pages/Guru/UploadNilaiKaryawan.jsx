import PrimaryButton from '@/Components/PrimaryButton'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import JenisPenilaianKaryawan from '@/Components/Sia/JenisPenilaianKaryawan'
import KategoriNilaiKaryawan from '@/Components/Sia/KategoriNilaiKaryawan'
import Tahun from '@/Components/Sia/Tahun'
import getKaryawanWithNilai from '@/Functions/getKaryawanWithNilai'
import getListKategoriPenilaianKaryawan from '@/Functions/getListKategoriPenilaianKaryawan'
import getListJenisPenilaianKaryawan from '@/Functions/getListJenisPenilaianKaryawan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const UploadNilaiKaryawan = ({ initTahun }) => {

    const { data, setData, post, errors, processing } = useForm({
        tahun: initTahun,
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        fileUpload: '',
    })

    const [listUser, setListUser] = useState([])
    const [listJenis, setListJenis] = useState([])
    const [listKategori, setListKategori] = useState([])


    async function getDataUser() {
        const response = await getKaryawanWithNilai(data.tahun, data.kategoriNilaiId, data.jenisPenilaianId)
        setListUser(response.listUser)
    }

    async function getDataKategori() {
        const response = await getListKategoriPenilaianKaryawan(data.tahun)
        setListKategori(response.listKategori)
    }

    async function getDataJenis() {
        const response = await getListJenisPenilaianKaryawan(data.tahun, data.kategoriNilaiId)
        setListJenis(response.listJenis)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.type === 'file' ? e.target.files[0] : e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('upload-nilai-karyawan.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Nilai')
                setData({ ...data })
                trackPromise(
                    getDataUser()
                )
            }
        })
    }

    useEffect(() => {

        if (data.tahun) {
            trackPromise(getDataKategori())
        }
    }, [data.tahun])

    useEffect(() => {

        if (data.kategoriNilaiId) {
            setData('jenisPenilaianId', '')
            trackPromise(getDataJenis())
        }
    }, [data.tahun, data.kategoriNilaiId])


    useEffect(() => {

        if (
            data.tahun
            && data.kategoriNilaiId
            && data.jenisPenilaianId
        )
            trackPromise(
                getDataUser()
            )

    }, [data.tahun, data.kategoriNilaiId, data.jenisPenilaianId])

    return (
        <>
            <Head title='Upload Nilai' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">upload nilai</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <KategoriNilaiKaryawan
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />

                <JenisPenilaianKaryawan
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={listJenis}
                />
            </div>

            {data.tahun && data.kategoriNilaiId && data.jenisPenilaianId &&
                <div className="flex flex-col space-y-5">
                    <DownloadLink
                        href={route('upload-nilai-karyawan.download', {
                            tahun: data.tahun,
                            kategoriNilaiId: data.kategoriNilaiId,
                            jenisPenilaianId: data.jenisPenilaianId,
                        })}
                        label='download draft' />

                    <div className="lg:inline-flex lg:space-y-0 space-y-2">
                        <FileUpload
                            id='fileUpload'
                            name='fileUpload'
                            label='untuk diupload'
                            message={errors.fileUpload}
                            handleChange={onHandleChange}
                        />
                        <div className='lg:flex lg:items-end'>
                            <PrimaryButton onClick={submit} children='upload' disabled={processing} />
                        </div>
                    </div>
                </div>
            }

            <div className="overflow-x-auto pt-5">
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
                                Nilai
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listUser && listUser.map((karyawan, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {karyawan.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {karyawan.nilai}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

UploadNilaiKaryawan.layout = page => <AppLayout children={page} />
export default UploadNilaiKaryawan