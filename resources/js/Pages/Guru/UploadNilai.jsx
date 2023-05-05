import PrimaryButton from '@/Components/PrimaryButton'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getSiswaWithNilai from '@/Functions/getSiswaWithNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const UploadNilai = ({ initTahun, initSemester, listMapel, listKelas, listKategori, listJenis }) => {

    const { data, setData, post, errors, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        fileUpload: ''
    })

    const [listSiswa, setListSiswa] = useState([])

    async function getDataSiswa() {
        const response = await getSiswaWithNilai(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setListSiswa(response.listSiswa)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.type === 'file' ? e.target.files[0] : e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('upload-nilai.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Nilai')
                setData({
                    tahun: data.tahun,
                    semester: data.semester,
                    kategoriNilaiId: data.kategoriNilaiId,
                    jenisPenilaianId: data.jenisPenilaianId,
                    kelasId: data.kelasId,
                    mataPelajaranId: data.mataPelajaranId
                })

                getDataSiswa()
            }
        })
    }

    useEffect(() => {
        if (
            data.tahun
            && data.mataPelajaranId
            && data.kelasId
        )
            router.reload({
                only: ['listKategori'],
                data: {
                    tahun: data.tahun,
                    mataPelajaranId: data.mataPelajaranId,
                    kelasId: data.kelasId
                }
            })

    }, [data.mataPelajaranId, data.kelasId])

    useEffect(() => {
        if (
            data.tahun
            && data.mataPelajaranId
        ) {
            setData('jenisPenilaianId', '')
            router.reload({
                only: ['listJenis'],
                data: {
                    tahun: data.tahun,
                    semester: data.semester,
                    kategoriNilaiId: data.kategoriNilaiId
                }
            })
        }

    }, [data.kategoriNilaiId])

    useEffect(() => {
        if (
            data.tahun
            && data.mataPelajaranId
        )
            router.reload({
                only: ['listKelas'],
                data: {
                    tahun: data.tahun,
                    mataPelajaranId: data.mataPelajaranId
                }
            })

    }, [data.mataPelajaranId])

    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriNilaiId
            && data.jenisPenilaianId
        )
            trackPromise(
                getDataSiswa()
            )

    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId])

    return (
        <>
            <Head title='Upload Nilai' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">upload nilai</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Semester
                    id='semester'
                    name='semester'
                    value={data.semester}
                    message={errors.semester}
                    handleChange={onHandleChange}
                />

                <MataPelajaran
                    id='mataPelajaranId'
                    name='mataPelajaranId'
                    value={data.mataPelajaranId}
                    message={errors.mataPelajaranId}
                    handleChange={onHandleChange}
                    listMapel={listMapel}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                />

                <KategoriNilai
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={listJenis}
                />
            </div>

            {data.tahun && data.semester && data.kategoriNilaiId && data.jenisPenilaianId && data.kelasId &&
                <div className="flex flex-col space-y-5">
                    <DownloadLink
                        href={route('upload-nilai.download', {
                            tahun: data.tahun,
                            semester: data.semester,
                            kategoriNilaiId: data.kategoriNilaiId,
                            jenisPenilaianId: data.jenisPenilaianId,
                            kelasId: data.kelasId,
                            mataPelajaranId: data.mataPelajaranId
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
                                    {siswa.penilaian.nilai}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

UploadNilai.layout = page => <AppLayout children={page} />
export default UploadNilai