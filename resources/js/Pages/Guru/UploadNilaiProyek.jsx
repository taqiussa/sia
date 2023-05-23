import PrimaryButton from '@/Components/PrimaryButton'
import Dimensi from '@/Components/Sia/Dimensi'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import Kelas from '@/Components/Sia/Kelas'
import Proyek from '@/Components/Sia/Proyek'
import Tahun from '@/Components/Sia/Tahun'
import getListAturanProyek from '@/Functions/getListAturanProyek'
import getListDimensi from '@/Functions/getListDimensi'
import getSiswaWithNilaiProyek from '@/Functions/getSiswaWithNilaiProyek'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const UploadNilaiProyek = ({ initTahun, listKelas }) => {

    const { data, setData, post, errors, processing } = useForm({
        tahun: initTahun,
        kelasId: '',
        proyekId: '',
        dimensiId: '',
        fileUpload: '',
        listProyek: [],
        listDimensi: []
    })

    const [listSiswa, setListSiswa] = useState([])

    async function getDataSiswa() {
        const response = await getSiswaWithNilaiProyek(data.tahun, data.kelasId, data.proyekId, data.dimensiId)
        setListSiswa(response.listSiswa)
    }

    async function getDataProyek() {
        const response = await getListAturanProyek(data.tahun)
        setData({ ...data, listProyek: response.listAturanProyek })
    }

    async function getDataDimensi() {
        const response = await getListDimensi(data.tahun, data.proyekId)
        setData({
            ...data,
            listDimensi: response.listDimensi
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.type === 'file' ? e.target.files[0] : e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('upload-nilai-proyek.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Nilai Proyek')
                setData({ ...data })
                trackPromise(
                    getDataSiswa()
                )
            }
        })
    }


    useEffect(() => {

        if (data.tahun) {
            trackPromise(getDataProyek())
        }
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.proyekId) {
            trackPromise(getDataDimensi())
        }
    }, [data.tahun, data.proyekId])


    useEffect(() => {

        if (
            data.tahun
            && data.kelasId
            && data.proyekId
            && data.dimensiId
        )
            trackPromise(
                getDataSiswa()
            )

    }, [data.tahun, data.kelasId, data.proyekId, data.dimensiId])

    return (
        <>
            <Head title='Upload Nilai Proyek' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">upload nilai proyek</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />


                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                />

                <Proyek
                    id='proyekId'
                    name='proyekId'
                    value={data.proyekId}
                    message={errors.proyekId}
                    handleChange={onHandleChange}
                    listProyek={data.listProyek}
                />

                <Dimensi
                    id='dimensiId'
                    name='dimensiId'
                    value={data.dimensiId}
                    message={errors.dimensiId}
                    handleChange={onHandleChange}
                    listDimensi={data.listDimensi}
                />
            </div>

            {data.tahun  && data.proyekId  &&
                <div className="flex flex-col space-y-5">
                    <DownloadLink
                        href={route('upload-nilai-proyek.download', {
                            tahun: data.tahun,
                            proyekId: data.proyekId,
                            kelasId: data.kelasId,
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
                        {listSiswa && listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.penilaian_proyek?.nilai}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

UploadNilaiProyek.layout = page => <AppLayout children={page} />
export default UploadNilaiProyek