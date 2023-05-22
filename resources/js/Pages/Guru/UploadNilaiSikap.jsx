import PrimaryButton from '@/Components/PrimaryButton'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import JenisSikap from '@/Components/Sia/JenisSikap'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import KategoriSikap from '@/Components/Sia/KategoriSikap'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getListJenis from '@/Functions/getListJenis'
import getListJenisSikap from '@/Functions/getListJenisSikap'
import getListKategori from '@/Functions/getListKategori'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithNilai from '@/Functions/getSiswaWithNilai'
import getSiswaWithNilaiSikap from '@/Functions/getSiswaWithNilaiSikap'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const UploadNilaiSikap = ({ initTahun, initSemester, listMapel, listKategori }) => {

    const { data, setData, post, errors, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriSikapId: '',
        jenisSikapId: '',
        fileUpload: '',
        listKelas: [],
        listJenis: []
    })

    const [listSiswa, setListSiswa] = useState([])

    async function getDataSiswa() {
        const response = await getSiswaWithNilaiSikap(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId)
        setListSiswa(response.listSiswa)
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, data.mataPelajaranId)
        setData({
            ...data,
            listKelas: response.listKelas
        })
    }

    async function getDataJenis() {
        const response = await getListJenisSikap(data.tahun, data.semester, data.kategoriSikapId, data.kelasId)
        setData({
            ...data,
            listJenis: response.listJenis
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.type === 'file' ? e.target.files[0] : e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('upload-nilai-sikap.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Nilai Sikap')
                setData({ ...data })
                trackPromise(
                    getDataSiswa()
                )
            }
        })
    }

    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            trackPromise(getDataKelas())
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.kategoriSikapId) {
            setData('jenisSikapId', '')
            trackPromise(getDataJenis())
        }
    }, [data.semester, data.kategoriSikapId])


    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriSikapId
            && data.jenisSikapId
        )
            trackPromise(
                getDataSiswa()
            )

    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriSikapId, data.jenisSikapId])

    return (
        <>
            <Head title='Upload Nilai Sikap' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">upload nilai sikap</div>
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
                    listKelas={data.listKelas}
                />

                <KategoriSikap
                    id='kategoriSikapId'
                    name='kategoriSikapId'
                    value={data.kategoriSikapId}
                    message={errors.kategoriSikapId}
                    handleChange={onHandleChange}
                    listKategori={listKategori}
                />

                <JenisSikap
                    id='jenisSikapId'
                    name='jenisSikapId'
                    value={data.jenisSikapId}
                    message={errors.jenisSikapId}
                    handleChange={onHandleChange}
                    listJenis={data.listJenis}
                />
            </div>

            {data.tahun && data.semester && data.kategoriSikapId && data.kelasId &&
                <div className="flex flex-col space-y-5">
                    <DownloadLink
                        href={route('upload-nilai-sikap.download', {
                            tahun: data.tahun,
                            semester: data.semester,
                            kategoriSikapId: data.kategoriSikapId,
                            jenisSikapId: data.jenisSikapId,
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
                                    {siswa.penilaian_sikap?.nilai}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

UploadNilaiSikap.layout = page => <AppLayout children={page} />
export default UploadNilaiSikap