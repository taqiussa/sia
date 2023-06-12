import Hapus from '@/Components/Sia/Hapus'
import SearchableSelect from '@/Components/Sia/SearchableSelect'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import getAllSiswa from '@/Functions/getAllSiswa'
import getSkorSiswaPerGuru from '@/Functions/getSkorSiswaPerGuru'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputSkor = ({ initTahun }) => {

    const { data, setData, errors, delete: destroy } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        nis: '',
        skorId: '',
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

    const [listData, setListData] = useState([])

    async function getDataSkor() {
        const response = await getSkorSiswaPerGuru(data.tahun, data.nis)
        setListData(response.listData)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus Skor Siswa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('hapus-skor.hapus',
                            {
                                id: id
                            }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Skor Siswa')
                                setData({ ...data })
                                trackPromise(getDataSkor())
                            },
                            preserveScroll: true,
                        }
                    )
            })
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getDataSiswa()
            )
    }, [])

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getDataSiswa()
            )
    }, [data.tahun])

    useEffect(() => {
        if (data.tahun && data.nis)
            trackPromise(
                getDataSkor()
            )
    }, [data.tahun, data.nis])


    return (
        <>
            <Head title='Input Skor' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">input skor</div>

            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 mb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />


            </div>
            <div className="mt-2">
                <SearchableSelect
                    id='nis'
                    name='nis'
                    label='nama siswa'
                    options={optionSiswa}
                    value={data.nis}
                    message={errors.nis}
                    onChange={(e) => setData('nis', e)}
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
                                Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Keterangan
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Skor
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
                        {listData && listData.map((dataSkor, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {hariTanggal(dataSkor.tanggal)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {dataSkor.siswa?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {dataSkor.kelas?.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {dataSkor.skors?.keterangan}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {dataSkor.skors?.skor}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {dataSkor.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus
                                        onClick={() => handleDelete(dataSkor.id)}
                                    />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

InputSkor.layout = page => <AppLayout children={page} />
export default InputSkor