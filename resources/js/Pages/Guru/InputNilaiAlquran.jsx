import DangerButton from '@/Components/DangerButton'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import JenisAlquran from '@/Components/Sia/JenisAlquran'
import KategoriAlquran from '@/Components/Sia/KategoriAlquran'
import Kelas from '@/Components/Sia/Kelas'
import Siswa from '@/Components/Sia/Siswa'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import getListJenisAlquranWithNilaiSiswa from '@/Functions/getListJenisAlquranWithNilaiSiswa'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswa from '@/Functions/getSiswa'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputNilaiAlquran = ({ initTahun, listKategoriAlquran }) => {

    const { data, setData, post, put, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        kelasId: '',
        nis: '',
        kategoriAlquran: '',
        jenisAlquran: '',
        nilai: '',
        listJenisAlquran: [],
        listKelas: [],
        listSiswa: []
    })

    async function getDataNilai() {
        const response = await getListJenisAlquranWithNilaiSiswa(data.kategoriAlquran, data.nis)
        setData({ ...data, listJenisAlquran: response.listJenisAlquran })
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, 12)
        setData({ ...data, listKelas: response.listKelas })
    }

    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setData({ ...data, listSiswa: response.listSiswa })
    }


    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-nilai-alquran.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Nilai')
                setData({ ...data })
                trackPromise(getDataNilai())
            }
        })
    }

    const semua = (e) => {
        e.preventDefault()

        put(route('input-nilai-alquran.semua'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Semua Nilai')
                setData({ ...data })
                trackPromise(getDataNilai())
            }
        })

    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Anda Yakin Menghapus ?',
                text: 'Hapus Nilai',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(
                        route('input-nilai-alquran.hapus', {
                            id: id,
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Nilai')
                                setData({ ...data })
                                trackPromise(getDataNilai())
                            }
                        }
                    )
                }
            })
    }

    useEffect(() => {

        if (data.tahun) {
            trackPromise(getDataKelas())
        }
    }, [])

    useEffect(() => {

        setData({
            tahun: data.tahun,
            kelasId: '',
            nis: '',
            kategoriAlquran: '',
            jenisAlquran: '',
            nilai: '',
            listJenisAlquran: [],
            listKelas: [],
            listSiswa: []
        })

        if (data.tahun) {
            trackPromise(getDataKelas())
        }
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.kelasId && data.kategoriAlquran && data.nis) {
            trackPromise(getDataNilai())
        }

    }, [data.kategoriAlquran, data.nis])

    useEffect(() => {
        if (data.tahun && data.kelasId) {
            trackPromise(getDataSiswa())
        }
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title="Input Nilai Al Qur'an" />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input nilai al qur'an</div>
            <form onSubmit={submit} className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
                    listKelas={data.listKelas}
                    handleChange={onHandleChange}
                />

                <Siswa
                    id='nis'
                    name='nis'
                    value={data.nis}
                    message={errors.nis}
                    listSiswa={data.listSiswa}
                    handleChange={onHandleChange}
                />

                <KategoriAlquran
                    id='kategoriAlquran'
                    name='kategoriAlquran'
                    value={data.kategoriAlquran}
                    message={errors.kategoriAlquran}
                    listKategoriAlquran={listKategoriAlquran}
                    handleChange={onHandleChange}
                />

                <JenisAlquran
                    id='jenisAlquran'
                    name='jenisAlquran'
                    value={data.jenisAlquran}
                    message={errors.jenisAlquran}
                    listJenisAlquran={data.listJenisAlquran}
                    handleChange={onHandleChange}
                />

                <InputText
                    id='nilai'
                    name='nilai'
                    label='nilai (A,B,C)'
                    value={data.nilai}
                    message={errors.nilai}
                    handleChange={onHandleChange}
                />

                <div className="flex items-end">
                    <PrimaryButton onClick={submit} disabled={processing} children='simpan' />
                </div>

            </form>

            <DangerButton onClick={semua} disabled={processing} children='nilai semua surah / juz' />

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
                                Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Guru
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listJenisAlquran && data.listJenisAlquran.map((jenis, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {jenis.penilaian?.tanggal ? hariTanggal(jenis.penilaian?.tanggal) : null}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {jenis.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {jenis.penilaian?.nilai}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {jenis.penilaian?.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {jenis.penilaian.id &&
                                        <Hapus onClick={() => handleDelete(jenis.penilaian.id)} />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

InputNilaiAlquran.layout = page => <AppLayout children={page} />
export default InputNilaiAlquran