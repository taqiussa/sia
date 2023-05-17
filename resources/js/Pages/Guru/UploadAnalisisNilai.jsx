import PrimaryButton from '@/Components/PrimaryButton'
import DownloadLink from '@/Components/Sia/DownloadLink'
import FileUpload from '@/Components/Sia/FileUpload'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Tahun from '@/Components/Sia/Tahun'
import getListJenis from '@/Functions/getListJenis'
import getListKategori from '@/Functions/getListKategori'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithAnalisisNilai from '@/Functions/getSiswaWithAnalisisNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const UploadAnalisisNilai = ({ initTahun, initSemester, listMapel }) => {

    const { data, setData, errors, post, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        fileUpload: '',
        listKelas: [],
        listKategori: [],
        listJenis: []
    })

    const [listSiswa, setListSiswa] = useState([])

    async function getDataSiswa() {
        const response = await getSiswaWithAnalisisNilai(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setListSiswa(response.listSiswa)
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, data.mataPelajaranId)
        setData({
            ...data,
            listKelas: response.listKelas
        })
    }

    async function getDataKategori() {
        const response = await getListKategori(data.tahun, data.kelasId)
        setData({
            ...data,
            listKategori: response.listKategori
        })
    }

    async function getDataJenis() {
        const response = await getListJenis(data.tahun, data.semester, data.kategoriNilaiId, data.kelasId)
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

        post(route('upload-analisis-nilai.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Analisis')
                setData({...data})
                trackPromise(getDataSiswa())
            }
        })
    }

    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriNilaiId
            && data.jenisPenilaianId
        ) {
            trackPromise(
                getDataSiswa()
            )
        } else {
            setListSiswa([])
        }

    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId])


    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            trackPromise(getDataKelas())
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.kelasId)
            trackPromise(getDataKategori())
    }, [data.kelasId])

    useEffect(() => {

        if (data.kategoriNilaiId) {
            setData('jenisPenilaianId', '')
            trackPromise(getDataJenis())
        }
    }, [data.semester, data.kategoriNilaiId])


    return (
        <>
            <Head title='Upload Analisis Nilai' />
            <div className="border-b-2 border-emerald-500 bg-emerald-200 font-bold text-lg text-center text-slate-600 uppercase mb-2">upload analisis nilai</div>
            <div className="grid grid-cols-2 gap-2 lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 mb-2">

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

                <KategoriNilai
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={data.listKategori}
                />

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={data.listJenis}
                />

            </div>
            {data.tahun && data.semester && data.kategoriNilaiId && data.jenisPenilaianId && data.kelasId &&
                <div className="flex flex-col space-y-5">
                    <div className="lg:inline-flex lg:space-y-0 space-y-2 space-x-5">
                        <DownloadLink
                            href={route('upload-analisis-nilai.download', {
                                tahun: data.tahun,
                                semester: data.semester,
                                kategoriNilaiId: data.kategoriNilaiId,
                                jenisPenilaianId: data.jenisPenilaianId,
                                kelasId: data.kelasId,
                                mataPelajaranId: data.mataPelajaranId
                            })}
                            label='download draft' />
                        <div className='text-red-500'>
                            kosongi kolom "skor_maks", skor_maks hanya digunakan oleh guru dengan cara penilaian pembobotan.
                        </div>
                    </div>

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
                    <thead className="text-sm text-slate-600 ">
                        <tr className=" capitalize whitespace-nowrap bg-gray-50">
                            <th className=" px-2 py-2">no</th>
                            <th className=" px-2 py-2 text-left pl-2 sticky left-0 bg-inherit">nama</th>
                            {data.kategoriNilaiId == 3 || data.kategoriNilaiId == 6 ?
                                <>
                                    <th className=" px-2 py-2">no 1</th>
                                    <th className=" px-2 py-2">no 2</th>
                                    <th className=" px-2 py-2">no 3</th>
                                    <th className=" px-2 py-2">no 4</th>
                                    <th className=" px-2 py-2">no 5</th>
                                    <th className=" px-2 py-2">no 6</th>
                                    <th className=" px-2 py-2">no 7</th>
                                    <th className=" px-2 py-2">no 8</th>
                                    <th className=" px-2 py-2">no 9</th>
                                    <th className=" px-2 py-2">no 10</th>
                                </>
                                :
                                <>
                                    <th className=" px-2 py-2">aspek 1</th>
                                    <th className=" px-2 py-2">aspek 2</th>
                                    <th className=" px-2 py-2">aspek 3</th>
                                    <th className=" px-2 py-2">aspek 4</th>
                                </>
                            }
                            <th className=" px-2 py-2">nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 sticky left-0 bg-inherit">
                                    {siswa.user.name}
                                </td>
                                {
                                    data.kategoriNilaiId == 3 || data.kategoriNilaiId == 6 ?
                                        <>
                                            {Array.from({ length: 10 }, (_, i) => i + 1).map((no) => (
                                                <td className="py-2 px-2 font-medium text-slate-600 text-center" key={no}>
                                                    {siswa.analisis_penilaian?.[`no_${no}`]}
                                                </td>
                                            ))}
                                        </>
                                        :
                                        <>
                                            {Array.from({ length: 4 }, (_, i) => i + 1).map((no) => (
                                                <td className="py-2 px-2 font-medium text-slate-600 text-center" key={no}>
                                                    {siswa.analisis_penilaian?.[`no_${no}`]}
                                                </td>
                                            ))}
                                        </>
                                }

                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
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

UploadAnalisisNilai.layout = page => <AppLayout children={page} />
export default UploadAnalisisNilai