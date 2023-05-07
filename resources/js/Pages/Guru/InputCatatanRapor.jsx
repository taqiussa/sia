import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import InputText from '@/Components/Sia/InputText'
import Kelas from '@/Components/Sia/Kelas'
import Semester from '@/Components/Sia/Semester'
import Siswa from '@/Components/Sia/Siswa'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getDataKelasWaliKelas from '@/Functions/getDataKelasWaliKelas'
import getSiswa from '@/Functions/getSiswa'
import getSiswaWithCatatan from '@/Functions/getSiswaWithCatatan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputAlpha = ({ initTahun, initSemester, listKelas }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
        nis: '',
        catatan: ''
    })

    const [listSiswa, setListSiswa] = useState([])
    const [listCatatan, setListCatatan] = useState([])

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    async function getData() {
        const response = await getDataKelasWaliKelas(data.tahun)
        setData('kelasId', response.kelasId)
    }


    async function getDataCatatan() {
        const response = await getSiswaWithCatatan(data.tahun, data.semester, data.kelasId)
        setListCatatan(response.listCatatan)
    }

    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('input-catatan-rapor.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Catatan Rapor Siswa Siswa')
                    setData({
                        tahun: data.tahun,
                        semester: data.semester,
                        kelasId: data.kelasId,
                        nis: '',
                        catatan: data.catatan
                    })
                    getDataCatatan()
                }
            })
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus Catatan Rapor Siswa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('input-catatan-rapor.hapus',
                            {
                                id: id
                            }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Catatan Rapor Siswa')
                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    kelasId: data.kelasId,
                                    nis: '',
                                    catatan: data.catatan
                                })

                                getDataCatatan()
                            }
                        }
                    )
            })
    }

    useEffect(() => {
        if (data.tahun) {
            trackPromise(
                getData()
            )
        }
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.kelasId
        ) {

            trackPromise(
                getDataSiswa(),
                getDataCatatan()
            )

        }
        else {
            setListCatatan([])
            setListSiswa([])
        }
    }, [data.tahun, data.semester, data.kelasId])

    return (
        <>
            <Head title='Input Catatan Rapor' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">input catatan rapor</div>
            <form onSubmit={submit} className='space-y-2'>
                <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 mb-2'>
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
                        handleChange={onHandleChange}
                        listKelas={listKelas}
                        disabled={true}
                    />


                </div>
                <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 mb-2'>
                    <div className="col-span-2">
                        <Siswa
                            id='nis'
                            name='nis'
                            value={data.nis}
                            message={errors.nis}
                            handleChange={onHandleChange}
                            listSiswa={listSiswa}
                        />
                    </div>

                </div>
                <InputArea
                    id='catatan'
                    name='catatan'
                    label='catatan'
                    value={data.catatan}
                    message={errors.catatan}
                    handleChange={onHandleChange}
                />
                <PrimaryButton
                    onClick={submit}
                    children='simpan'
                    disabled={processing}
                />
            </form>
            <div className="overflow-x-auto mt-2">
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
                                Catatan
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listCatatan && listCatatan.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.catatan?.catatan}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                    {
                                        siswa.catatan.id &&
                                        <Hapus
                                            onClick={() => handleDelete(siswa.catatan.id)}
                                        />}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

        </>
    )
}

InputAlpha.layout = page => <AppLayout children={page} />
export default InputAlpha