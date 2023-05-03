import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import Tahun from '@/Components/Sia/Tahun'
import Semester from '@/Components/Sia/Semester'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Kelas from '@/Components/Sia/Kelas'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import getSiswaPengayaan from '@/Functions/getSiswaPengayaan'
import { trackPromise } from 'react-promise-tracker'
import InputTextBlur from '@/Components/Sia/InputTextBlur'
import Tanggal from '@/Components/Sia/Tanggal'
import moment from 'moment'
import InputArea from '@/Components/Sia/InputArea'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import axios from 'axios'

const InputNilaiPengayaan = ({ initTahun, initSemester, listMapel, listKelas, listKategori, listJenis }) => {
    const { data, setData, post, errors, processing } = useForm({
        id: '',
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        ki: '',
        kd: '',
        indikator: '',
        bentukPelaksanaan: '',
        banyakSoal: '',
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [pengayaan, setPengayaan] = useState([])
    const [message, setMessage] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaPengayaan(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setListSiswa(response.listSiswa)
        if (response.pengayaan !== '') {
            setPengayaan(response.pengayaan)
            setData({
                id: response.pengayaan.id,
                tahun: data.tahun,
                semester: data.semester,
                mataPelajaranId: data.mataPelajaranId,
                kelasId: data.kelasId,
                kategoriNilaiId: data.kategoriNilaiId,
                jenisPenilaianId: data.jenisPenilaianId,
                tanggal: response.pengayaan.tanggal,
                ki: response.pengayaan.ki,
                kd: response.pengayaan.kd,
                indikator: response.pengayaan.indikator,
                bentukPelaksanaan: response.pengayaan.bentuk_pelaksanaan,
                banyakSoal: response.pengayaan.banyak_soal,
                arrayInput: []
            })
        } else {
            setPengayaan([])
            setData({
                id: '',
                tahun: data.tahun,
                semester: data.semester,
                mataPelajaranId: data.mataPelajaranId,
                kelasId: data.kelasId,
                kategoriNilaiId: data.kategoriNilaiId,
                jenisPenilaianId: data.jenisPenilaianId,
                tanggal: data.tanggal,
                ki: '',
                kd: '',
                indikator: '',
                bentukPelaksanaan: '',
                banyakSoal: '',
                arrayInput: []
            })
        }
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, kelasId, nilai, pengayaanId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: namaSiswa
            },
            penilaian:
            {
                nilai
            },
            pengayaan: {
                id: id,
                pengayaan_id: pengayaanId,
                nilai_pengayaan: e.target.value
            }
        })

        setMessage([])

        setListSiswa(newList)

        setCount(count + 1)

    }

    const onHandleBlur = (e, id, nis, kelasId, nilaiAwal, pengayaanId) => {
        e.preventDefault()

        axios.put(route('input-nilai-pengayaan.update', {
            id: id,
            tanggal: data.tanggal,
            tahun: data.tahun,
            semester: data.semester,
            mataPelajaranId: data.mataPelajaranId,
            kategoriNilaiId: data.kategoriNilaiId,
            jenisPenilaianId: data.jenisPenilaianId,
            ki: data.ki,
            kd: data.kd,
            indikator: data.indikator,
            bentukPelaksanaan: data.bentukPelaksanaan,
            banyakSoal: data.banyakSoal,
            nis: nis,
            kelasId: kelasId,
            pengayaanId: pengayaanId,
            nilaiAwal: nilaiAwal,
            nilaiPengayaan: e.target.value,
        }))
            .then(response => {

                setListSiswa(response.data.listSiswa)

                setMessage({
                    nis: response.data.nis,
                    message: response.data.message
                })
            })
            .catch(error => {
                Sweet
                    .fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.response.data.message
                    })
            })
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-nilai-pengayaan.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Data Pengayaan')
                setData({ ...data })
                trackPromise(
                    getDataSiswa()
                )
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

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    useEffect(() => {

        const timeoutId = setTimeout(() => {
            setMessage([]);
        }, 1000);

        return () => {
            clearTimeout(timeoutId);
        };
    }, [message])


    return (
        <>
            <Head title='Input Nilai Pengayaan' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-3">input nilai pengayaan</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal pengayaan'
                    value={data.tanggal}
                    message={errors.tanggal}
                    handleChange={onHandleChange}
                />

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
                <div className="col-span-2">

                    <JenisPenilaian
                        id='jenisPenilaianId'
                        name='jenisPenilaianId'
                        value={data.jenisPenilaianId}
                        message={errors.jenisPenilaianId}
                        handleChange={onHandleChange}
                        listJenis={listJenis}
                    />
                </div>
            </div>
            <div className='lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 space-y-2 pb-2'>
                <InputArea
                    id='ki'
                    name='ki'
                    label='K.I. (di isi jika perlu)'
                    value={data.ki}
                    message={errors.ki}
                    handleChange={onHandleChange}
                />
                <InputArea
                    id='kd'
                    name='kd'
                    label='K.D. (di isi jika perlu)'
                    value={data.kd}
                    message={errors.kd}
                    handleChange={onHandleChange}
                />
            </div>
            <div className='pb-2'>
                <InputArea
                    id='indikator'
                    name='indikator'
                    label='indikator (di isi jika perlu)'
                    value={data.indikator}
                    message={errors.indikator}
                    handleChange={onHandleChange}
                />
            </div>
            <div className='lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 space-y-2 pb-2'>
                <InputArea
                    id='bentukPelaksanaan'
                    name='bentukPelaksanaan'
                    label='bentuk pelaksanaan (di isi jika perlu)'
                    value={data.bentukPelaksanaan}
                    message={errors.bentukPelaksanaan}
                    handleChange={onHandleChange}
                />
                <InputArea
                    id='banyakSoal'
                    name='banyakSoal'
                    label='banyak soal (di isi jika perlu)'
                    value={data.banyakSoal}
                    message={errors.banyakSoal}
                    handleChange={onHandleChange}
                />
            </div>
            <PrimaryButton
                children='simpan'
                onClick={submit}
                disabled={processing}
            />
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
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai Awal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai Pengayaan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa
                            .filter(siswa => siswa.penilaian.nilai > 75)
                            .map((siswa, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.penilaian?.nilai}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        <div className='flex flex-col'>

                                            <InputTextBlur
                                                id='pengayaan'
                                                name='pengayaan'
                                                className='w-auto max-w-[60px]'
                                                value={siswa.pengayaan.nilai_pengayaan ?? ''}
                                                handleChange={(e) => handleDynamic(e, index, siswa.pengayaan?.id, siswa.nis, siswa.user.name, siswa.kelas_id, siswa.penilaian.nilai, siswa.pengayaan?.pengayaan_id ?? pengayaan.id)}
                                                handleBlur={(e) => onHandleBlur(e, siswa.pengayaan?.id, siswa.nis, siswa.kelas_id, siswa.penilaian.nilai, siswa.pengayaan?.pengayaan_id ?? pengayaan.id)}
                                            />

                                            {message && message.nis == siswa.nis &&
                                                (
                                                    <span className='text-emerald-500'>{message.message}</span>
                                                )}

                                            {data.arrayInput.length > 0 && data.arrayInput[index]?.pengayaan.nilai_pengayaan > 100 && (
                                                <span className='text-red-500'>Nilai Maksimal 100</span>
                                            )}

                                        </div>
                                    </td>
                                </tr>
                            ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

InputNilaiPengayaan.layout = page => <AppLayout children={page} />
export default InputNilaiPengayaan