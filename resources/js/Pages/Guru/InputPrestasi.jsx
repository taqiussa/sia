import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import SearchableSelect from '@/Components/Sia/SearchableSelect'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getAllSiswa from '@/Functions/getAllSiswa'
import getPrestasi from '@/Functions/getPrestasi'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm, usePage } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputPrestasi = ({ initTahun, initSemester }) => {

    const { auth } = usePage().props

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        nis: '',
        prestasi: '',
        keterangan: '',
        listPrestasi: [],
    })

    const [listSiswa, setListSiswa] = useState([])
    const optionSiswa = listSiswa.map((siswa) => ({
        value: siswa.nis,
        label: `${siswa.user?.name} - ${siswa.kelas?.nama}`
    }))

    async function getDataSiswa() {
        const response = await getAllSiswa(data.tahun)
        setListSiswa(response.listSiswa)
    }

    async function getDataPrestasi() {
        const response = await getPrestasi(data.tahun, data.semester)
        setData({
            ...data,
            listPrestasi: response.listPrestasi
        })
    }

    const optionsSiswa = listSiswa.map((siswa) => ({
        value: siswa.nis,
        label: `${siswa.user?.name} - ${siswa.kelas?.nama}`
    }))

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-prestasi.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Simpan Prestasi')
                setData({ ...data })
                trackPromise(getDataPrestasi())
            }
        })
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Menghapus Prestasi',
                text: 'Anda yakin menghapus data prestasi ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('input-prestasi.hapus',
                            {
                                id: id,
                            }
                        ),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Prestasi')
                                trackPromise(getDataPrestasi())

                            }
                        }
                    )

            })
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(getDataSiswa())
    }, [data.tahun])

    useEffect(() => {
        if (data.tahun && data.semester)
            trackPromise(getDataPrestasi())

    }, [data.tahun, data.semester])

    return (
        <>
            <Head title='Input Prestasi' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-lg text-center text-slate-600 font-bold uppercase mb-2">input prestasi</div>
            <div className="lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 space-y-2">
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

                <div className="col-span-2">
                    <SearchableSelect
                        id='nis'
                        name='nis'
                        label='siswa'
                        options={optionSiswa}
                        value={data.nis}
                        message={errors.nis}
                        onChange={(e) => setData('nis', e)}
                    />
                </div>
            </div>
            <div className="lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 space-y-2 pb-2">
                <InputArea
                    id='prestasi'
                    name='prestasi'
                    label='prestasi'
                    value={data.prestasi}
                    message={errors.prestasi}
                    handleChange={onHandleChange}
                />

                <InputArea
                    id='keterangan'
                    name='keterangan'
                    label='keterangan'
                    value={data.keterangan}
                    message={errors.keterangan}
                    handleChange={onHandleChange}
                />
            </div>
            <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
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
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Prestasi
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Keterangan
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
                        {data.listPrestasi && data.listPrestasi.map((prestasi, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {prestasi.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {prestasi.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {prestasi.prestasi}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {prestasi.keterangan}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {prestasi.guru?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {auth.user.id == prestasi.user_id &&
                                        <Hapus
                                            onClick={() => handleDelete(prestasi.id)}
                                        />
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

InputPrestasi.layout = page => <AppLayout children={page} />
export default InputPrestasi