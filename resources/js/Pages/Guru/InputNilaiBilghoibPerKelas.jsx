import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import JenisAlquran from '@/Components/Sia/JenisAlquran'
import Kelas from '@/Components/Sia/Kelas'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithNilaiAlquran from '@/Functions/getSiswaWithNilaiAlquran'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputNilaiBilghoibPerKelas = ({ initTahun, listJenisAlquran }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        kelasId: '',
        jenisAlquran: '',
        nilai: '',
        listKelas: [],
        listSiswa: []
    })

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, 12)
        setData({ ...data, listKelas: response.listKelas })
    }

    async function getDataSiswa() {
        const response = await getSiswaWithNilaiAlquran(data.tahun, data.kelasId, data.jenisAlquran)
        setData({ ...data, listSiswa: response.listSiswa })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-nilai-bilghoib-per-kelas.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Nilai')
                setData({ ...data })
                trackPromise(getDataSiswa())
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
                        route('input-nilai-bilghoib-per-kelas.hapus', {
                            id: id,
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Nilai')
                                setData({ ...data })
                                trackPromise(getDataSiswa())
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
        if (data.tahun) {
            trackPromise(getDataKelas())
        }

        if (data.tahun && data.kelasId && data.jenisAlquran) {
            trackPromise(getDataSiswa())
        }
    }, [data.tahun, data.kelasId, data.jenisAlquran])

    return (
        <>
            <Head title='Bilghoib Per Kelas' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input nilai al qur'an bilghoib per kelas</div>
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

                <JenisAlquran
                    id='jenisAlquran'
                    name='jenisAlquran'
                    value={data.jenisAlquran}
                    message={errors.jenisAlquran}
                    listJenisAlquran={listJenisAlquran}
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
                        {data.listSiswa && data.listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {siswa.penilaian_alquran?.tanggal ? hariTanggal(siswa.penilaian_alquran?.tanggal) : null}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {siswa.penilaian_alquran?.nilai}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 whitespace-nowrap">
                                    {siswa.penilaian_alquran?.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.penilaian_alquran.id &&
                                        <Hapus onClick={() => handleDelete(siswa.penilaian_alquran?.id)} />
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

InputNilaiBilghoibPerKelas.layout = page => <AppLayout children={page} />
export default InputNilaiBilghoibPerKelas