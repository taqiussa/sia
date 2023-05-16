import PrimaryButton from '@/Components/PrimaryButton'
import Guru from '@/Components/Sia/Guru'
import Hapus from '@/Components/Sia/Hapus'
import Hari from '@/Components/Sia/Hari'
import Jam from '@/Components/Sia/Jam'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { namaHari } from '@/Functions/functions'
import getListJadwalJamKosong from '@/Functions/getListJadwalJamKosong'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const JadwalJamKosong = ({ initTahun, initSemester, listUser }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        userId: '',
        hari: '',
        jam: '',
        listJadwal: []
    })

    async function getDataKosong() {
        const response = await getListJadwalJamKosong(data.tahun, data.userId)
        setData({ ...data, listJadwal: response.listJadwal })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {

        e.preventDefault()

        post(route('jadwal-jam-kosong.simpan'),

            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Jam Kosong')
                    setData({ ...data })
                    getDataKosong()
                }
            }
        )
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Menghapus Jadwal Jam Kosong',
                text: 'Anda yakin menghapus ?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('jadwal-jam-kosong.hapus', {
                            id: id,
                            userId: data.userId
                        }
                        ),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Jadwal Jam Kosong')
                                setData({ ...data })
                                getDataKosong()
                            }
                        }
                    )
            })

    }

    useEffect(() => {

        if (data.userId)
            trackPromise(getDataKosong())

    }, [data.userId])

    return (
        <>
            <Head title='Jadwal Jam Kosong' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 text-center text-lg text-slate-600 mb-2 uppercase">
                jadwal jam kosong
            </div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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

                <Guru
                    id='userId'
                    name='userId'
                    value={data.userId}
                    message={errors.userId}
                    handleChange={onHandleChange}
                    listUser={listUser}
                />

                <Hari
                    id='hari'
                    name='hari'
                    value={data.hari}
                    message={errors.hari}
                    handleChange={onHandleChange}
                />

                <Jam
                    id='jam'
                    name='jam'
                    value={data.jam}
                    message={errors.jam}
                    handleChange={onHandleChange}
                />

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
                                Semester
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Hari
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jam
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listJadwal && data.listJadwal.map((jadwal, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {jadwal.semester}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {namaHari(jadwal.hari)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {jadwal.jam}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <Hapus onClick={() => handleDelete(jadwal.id)} />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )
}

JadwalJamKosong.layout = page => <AppLayout children={page} />
export default JadwalJamKosong