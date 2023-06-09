import PrimaryButton from '@/Components/PrimaryButton'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import JenisAnalisisAlquran from '@/Components/Sia/JenisAnalisisAlquran'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import Kategori from '@/Components/Sia/Kategori'
import Kelas from '@/Components/Sia/Kelas'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getListJenis from '@/Functions/getListJenis'
import getListKategori from '@/Functions/getListKategori'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithAnalisisNilai from '@/Functions/getSiswaWithAnalisisNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const UploadAnalisisAlquran = ({ initSemester, initTahun }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        kelasId: '',
        jenisAnalisis: '',
        fileUpload: '',
        listJenis: [],
        listKategori: [],
        listKelas: [],
        listSiswa: []
    })

    async function getDataSiswa() {
        const response = await getSiswaWithAnalisisNilai(data.tahun, data.semester, 12, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setData({ ...data, listSiswa: response.listSiswa })
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, 12)
        setData({ ...data, listKelas: response.listKelas })
    }

    async function getDataKategori() {
        const response = await getListKategori(data.tahun, data.kelasId)
        setData({
            ...data,
            listKategori: response.listKategori
        })
    }

    async function getDataJenis() {
        const response = await getListJenis(data.tahun, data.semester, data.kategoriNilaiId)
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

        post(route('upload-analisis-alquran.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Analisis')
                setData({...data})
                trackPromise(getDataSiswa())
            }
        })
    }

    useEffect(() => {
        if (data.tahun) {
            trackPromise(getDataKelas())
        }
    }, [data.tahun])

    useEffect(() => {
        if (data.kelasId)
            trackPromise(getDataKategori())
    }, [data.kelasId])

    useEffect(() => {
        if (data.kategoriNilaiId)
            trackPromise(getDataJenis())
    }, [data.kategoriNilaiId])

    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.kategoriNilaiId
            && data.jenisPenilaianId
            && data.kelasId
            && data.jenisAnalisis
        ) {
            trackPromise(getDataSiswa())
        }

    }, [data.tahun, data.jenisPenilaianId, data.jenisAnalisis])


    return (
        <>
            <Head title="Upload Analisis Al Qur'an" />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">upload analisis al qur'an</div>
            <form onSubmit={submit} className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    listKelas={data.listKelas}
                    handleChange={onHandleChange}
                />

                <Kategori
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    listKategori={data.listKategori}
                    handleChange={onHandleChange}
                />

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    listJenis={data.listJenis}
                    handleChange={onHandleChange}
                />

                <JenisAnalisisAlquran
                    id='jenisAnalisis'
                    name='jenisAnalisis'
                    value={data.jenisAnalisis}
                    message={errors.jenisAnalisis}
                    handleChange={onHandleChange}
                />

                {data.tahun && data.semester && data.kategoriNilaiId && data.jenisPenilaianId && data.kelasId && data.jenisAnalisis &&
                    <div className="flex flex-col space-y-5">

                        <DownloadLink
                            href={route('upload-analisis-alquran.download', {
                                tahun: data.tahun,
                                semester: data.semester,
                                kategoriNilaiId: data.kategoriNilaiId,
                                jenisPenilaianId: data.jenisPenilaianId,
                                kelasId: data.kelasId,
                                jenisAnalisis: data.jenisAnalisis
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

            </form>


            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            {data.jenisAnalisis == 'Proyek' ?
                                <>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Kebenaran
                                    </th>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Keindahan
                                    </th>
                                </>
                                :
                                <>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Kelancaran
                                    </th>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Makhroj
                                    </th>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Tajwid
                                    </th>
                                </>
                            }
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listSiswa && data.listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {siswa.user?.name}
                                </td>
                                {data.jenisAnalisis == 'Proyek' ?
                                    <>
                                        <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                            {siswa.analisis_alqurans && siswa.analisis_alqurans
                                                .filter((nilai) => nilai.indikator == 1)
                                                .map((nilai, index) => (
                                                    <div key={index}>
                                                        {nilai.nilai}
                                                    </div>
                                                ))}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                            {siswa.analisis_alqurans && siswa.analisis_alqurans
                                                .filter((nilai) => nilai.indikator == 2)
                                                .map((nilai, index) => (
                                                    <div key={index}>
                                                        {nilai.nilai}
                                                    </div>
                                                ))}
                                        </td>
                                    </>
                                    :
                                    <>
                                        <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                            {siswa.analisis_alqurans && siswa.analisis_alqurans
                                                .filter((nilai) => nilai.indikator == 3)
                                                .map((nilai, index) => (
                                                    <div key={index}>
                                                        {nilai.nilai}
                                                    </div>
                                                ))}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                            {siswa.analisis_alqurans && siswa.analisis_alqurans
                                                .filter((nilai) => nilai.indikator == 4)
                                                .map((nilai, index) => (
                                                    <div key={index}>
                                                        {nilai.nilai}
                                                    </div>
                                                ))}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                            {siswa.analisis_alqurans && siswa.analisis_alqurans
                                                .filter((nilai) => nilai.indikator == 5)
                                                .map((nilai, index) => (
                                                    <div key={index}>
                                                        {nilai.nilai}
                                                    </div>
                                                ))}
                                        </td>
                                    </>
                                }
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {siswa.penilaian?.nilai}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

UploadAnalisisAlquran.layout = page => <AppLayout children={page} />
export default UploadAnalisisAlquran