import PrimaryButton from '@/Components/PrimaryButton'
import Ekstrakurikuler from '@/Components/Sia/Ekstrakurikuler'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import JenisKelamin from '@/Components/Sia/JenisKelamin'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getSiswaEkstraWithNilai from '@/Functions/getSiswaEkstraWithNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputNilaiEkstrakurikuler = ({ initTahun, initSemester, listEkstrakurikuler }) => {

    const { data, setData, errors, post, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        ekstrakurikulerId: '',
        jenisKelamin: '',
        nis: '',
        nilai: '',
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaEkstraWithNilai(data.tahun, data.semester, data.ekstrakurikulerId, data.jenisKelamin)
        setListSiswa(response.listSiswa)
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, namaKelas, kelasId, ekstrakurikulerId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            ekstrakurikuler_id: ekstrakurikulerId,
            user: {
                name: namaSiswa
            },
            kelas: {
                nama: namaKelas
            },
            penilaian: {
                id: id,
                nilai: e.target.value
            }
        })

        setListSiswa(newList)

        setCount(count + 1)

    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('input-nilai-ekstrakurikuler.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Penilaian')
                    setData({ ...data })
                    getDataSiswa()
                },
            }
        )
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus Nilai!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('input-nilai-ekstrakurikuler.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Penilaian')
                                setData({ ...data })
                                getDataSiswa()
                            }
                        }
                    )
            })
    }


    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.ekstrakurikulerId
            && data.jenisKelamin
        )
            trackPromise(
                getDataSiswa()
            )


    }, [data.tahun, data.semester, data.ekstrakurikulerId, data.jenisKelamin])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    return (
        <>
            <Head title='Absensi Ekstrakurikuler' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input nilai ekstrakurikuler</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>

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
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nilai
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa.map((siswa, index) => (
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
                                    <div className='flex flex-col'>

                                        <InputText
                                            id='penilaian'
                                            name='penilaian'
                                            message={errors.penilaian}
                                            value={siswa.penilaian.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian.id, siswa.nis, siswa.user.name, siswa.kelas?.nama, siswa.kelas_id, siswa.ekstrakurikuler_id)}
                                        />

                                        {data.arrayInput.length > 0 && data.arrayInput[index]?.penilaian.nilai > 100 && (
                                            <span className='text-red-500'>Nilai Maksimal 100</span>
                                        )}

                                    </div>
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {
                                        siswa.penilaian?.id &&
                                        <Hapus onClick={() => handleDelete(siswa.penilaian.id)} />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className="flex justify-end">
                <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
            </div>
        </>
    )
}
InputNilaiEkstrakurikuler.layout = page => <AppLayout children={page} />
export default InputNilaiEkstrakurikuler