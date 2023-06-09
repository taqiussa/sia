import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import Tahun from '@/Components/Sia/Tahun'
import Semester from '@/Components/Sia/Semester'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Kelas from '@/Components/Sia/Kelas'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import { trackPromise } from 'react-promise-tracker'
import Tanggal from '@/Components/Sia/Tanggal'
import moment from 'moment'
import InputArea from '@/Components/Sia/InputArea'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import getSiswaRemidi from '@/Functions/getSiswaRemidi'
import Hapus from '@/Components/Sia/Hapus'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getListKategori from '@/Functions/getListKategori'
import getListJenis from '@/Functions/getListJenis'
import InputText from '@/Components/Sia/InputText'

const InputNilaiRemidi = ({ initTahun, initSemester, listMapel }) => {
    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        id: '',
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        ki: '',
        materi: '',
        catatan: '',
        listKelas: [],
        listKategori: [],
        listJenis: [],
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [remidi, setRemidi] = useState([])
    const [kkm, setKkm] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaRemidi(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setListSiswa(response.listSiswa)
        if (response.remidi !== '') {
            setRemidi(response.remidi)
            setKkm(response.kkm)
            setData({
                ...data,
                id: response.remidi.id,
                tanggal: response.remidi.tanggal,
                ki: response.remidi.ki,
                materi: response.remidi.materi,
                catatan: response.remidi.catatan,
                arrayInput: []
            })
        } else {
            setRemidi([])
            setKkm(response.kkm)
            setData({
                ...data,
                id: '',
                ki: '',
                materi: '',
                catatan: '',
                arrayInput: []
            })
        }
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
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, kelasId, penilaianNilai, nilaiAwal, nilaiAkhir, remidiId) => {

        const newList = [...listSiswa];
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: namaSiswa
            },
            penilaian: {
                nilai: penilaianNilai
            },
            remidi: {
                id: id,
                remidi_id: remidiId,
                nilai_awal: nilaiAwal,
                nilai_akhir: nilaiAkhir,
                nilai_remidi: e.target.value,
            }
        })

        setListSiswa(newList);
        setCount(count + 1);
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-nilai-remidi.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Data Remidi')
                setData({ ...data })
                trackPromise(
                    getDataSiswa()
                )
            }
        })
    }

    const handleDelete = (remidiId, nilaiAwal, nis, kelasId) => {

        Sweet
            .fire({
                title: 'Menghapus Nilai Remidi',
                text: 'Anda akan menghapus nilai remidi dan mengembalikan nilai PH ke nilai awal ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('input-nilai-remidi.hapus', {
                            remidiId: remidiId,
                            nilaiAwal: nilaiAwal,
                            nis: nis,
                            kelasId: kelasId,
                            tanggal: data.tanggal,
                            tahun: data.tahun,
                            semester: data.semester,
                            mataPelajaranId: data.mataPelajaranId,
                            kategoriNilaiId: data.kategoriNilaiId,
                            jenisPenilaianId: data.jenisPenilaianId,
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Menghapus nilai remidi')
                                setData({ ...data })
                                trackPromise(
                                    getDataSiswa()
                                )
                            }
                        }
                    )
            })

    }

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

    console.log(listSiswa)
    return (
        <>
            <Head title='Input Nilai Remidi' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 font-bold uppercase mb-3">input nilai remidi</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tanggal
                    id='tanggal'
                    name='tanggal'
                    label='tanggal remidi'
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
                <div className="col-span-2">

                    <JenisPenilaian
                        id='jenisPenilaianId'
                        name='jenisPenilaianId'
                        value={data.jenisPenilaianId}
                        message={errors.jenisPenilaianId}
                        handleChange={onHandleChange}
                        listJenis={data.listJenis}
                    />
                </div>
            </div>
            <div className='lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 space-y-2 pb-2'>
                <InputArea
                    id='ki'
                    name='ki'
                    label='K.I. (di isi jika perlu)'
                    value={data.ki || ''}
                    message={errors.ki}
                    handleChange={onHandleChange}
                />
                <InputArea
                    id='materi'
                    name='materi'
                    label='materi (di isi jika perlu)'
                    value={data.materi || ''}
                    message={errors.materi}
                    handleChange={onHandleChange}
                />
            </div>
            <div className='pb-2'>
                <InputArea
                    id='catatan'
                    name='catatan'
                    label='catatan (di isi jika perlu)'
                    value={data.catatan || ''}
                    message={errors.catatan}
                    handleChange={onHandleChange}
                />
            </div>
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
                                Nilai Remidi
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai Akhir
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa
                            // .filter(siswa => siswa.penilaian.nilai < kkm || siswa.remidi.nilai_remidi != null)
                            .map((siswa, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.remidi?.nilai_awal ?? siswa.penilaian?.nilai}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        <div className='flex flex-col'>

                                            <InputText
                                                id='remidi'
                                                name='remidi'
                                                className='w-auto max-w-[60px]'
                                                value={siswa.remidi?.nilai_remidi ?? ''}
                                                handleChange={(e) => handleDynamic(e, index, siswa.remidi?.id, siswa.nis, siswa.user.name, siswa.kelas_id, siswa.penilaian?.nilai, siswa.remidi?.nilai_awal ?? siswa.penilaian?.nilai, siswa.remidi?.nilai_akhir, siswa.remidi?.remidi_id ?? remidi.id)}
                                            />

                                            {data.arrayInput.length > 0 && data.arrayInput[index]?.remidi?.nilai_remidi > 100 && (
                                                <span className='text-red-500'>Nilai Maksimal 100</span>
                                            )}

                                        </div>
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.remidi?.nilai_akhir}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {siswa.remidi?.id && (
                                            <Hapus onClick={() => handleDelete(siswa.remidi.id, siswa.remidi.nilai_awal, siswa.nis, siswa.kelas_id)} />
                                        )}
                                    </td>
                                </tr>
                            ))
                        }
                    </tbody>
                </table>
            </div>
            <div className="flex justify-end py-5">
                <PrimaryButton
                    children='simpan'
                    onClick={submit}
                    disabled={processing}
                />
            </div>
        </>
    )
}

InputNilaiRemidi.layout = page => <AppLayout children={page} />
export default InputNilaiRemidi