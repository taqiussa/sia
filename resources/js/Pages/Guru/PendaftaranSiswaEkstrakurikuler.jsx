import PrimaryButton from '@/Components/PrimaryButton'
import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import Hapus from '@/Components/Sia/Hapus'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import SearchableSelect from '@/Components/Sia/SearchableSelect'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getAllSiswaBelumEkstra from '@/Functions/getAllSiswaBelumEkstra'
import getSiswaEkstra from '@/Functions/getSiswaEkstra'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const PendaftaranSiswaEkstrakurikuler = ({ initTahun, listEkstrakurikuler }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        ekstrakurikulerId: '',
        jenisKelamin: '',
        nis: '',
        listSiswa: [],
        listSiswaBelum: []
    })

    const optionsSiswa = data.listSiswaBelum.map((siswa) => ({
        value: siswa.nis,
        label: `${siswa.user?.name} - ${siswa.kelas?.nama}`
    }))

    async function getDataSiswaBelum() {
        const response = await getAllSiswaBelumEkstra(data.tahun)
        setData({
            ...data,
            listSiswaBelum: response.listSiswaBelum
        })
    }

    async function getDataSiswaEkstra() {
        const response = await getSiswaEkstra(data.tahun, data.ekstrakurikulerId, data.jenisKelamin)
        setData({
            ...data,
            listSiswa: response.listSiswa
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('pendaftaran-siswa-ekstrakurikuler.simpan'), {
            onSuccess: () => {
                toast.success('Berhasil Mendaftarkan Siswa Ekstra')
                setData({ ...data })
                trackPromise(getDataSiswaEkstra())
            }
        })
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Menghapus Siswa',
                text: 'Anda Yakin Menghapus Siswa Ekstrakurikuler?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('pendaftaran-siswa-ekstrakurikuler.hapus',
                            {
                                id: id,
                            }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Siswa')
                                setData({ ...data })
                                trackPromise(getDataSiswaEkstra())
                            }
                        })
            })
    }

    useEffect(() => {

        if (data.tahun && data.ekstrakurikulerId && data.jenisKelamin)
            trackPromise(getDataSiswaEkstra())

    }, [data.tahun, data.ekstrakurikulerId, data.jenisKelamin])

    useEffect(() => {

        if (data.tahun)
            trackPromise(getDataSiswaBelum())

    }, [data.tahun])

    return (
        <>
            <Head title='Pendaftaran Siswa Ekstrakurikuler' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">pendaftaran siswa ekstrakurikuler</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Ekstrakurikuler
                    id='ekstrakurikulerId'
                    name='ekstrakurikulerId'
                    value={data.ekstrakurikulerId}
                    message={errors.ekstrakurikulerId}
                    handleChange={onHandleChange}
                    listEkstrakurikuler={listEkstrakurikuler}
                />

                <JenisKelamin
                    id='jenisKelamin'
                    name='jenisKelamin'
                    value={data.jenisKelamin}
                    message={errors.jenisKelamin}
                    handleChange={onHandleChange}
                />

                <div className="col-span-2">

                    <SearchableSelect
                        id='nis'
                        name='nis'
                        label='siswa belum ikut ekstra'
                        options={optionsSiswa}
                        value={data.nis}
                        message={errors.nis}
                        onChange={(e) => setData('nis', e)}
                    />
                </div>
            </div>

            <PrimaryButton onClick={submit} children='simpan' disabled={processing} />

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
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(siswa.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

PendaftaranSiswaEkstrakurikuler.layout = page => <AppLayout children={page} />
export default PendaftaranSiswaEkstrakurikuler