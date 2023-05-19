import PrimaryButton from '@/Components/PrimaryButton'
import Dimensi from '@/Components/Sia/Dimensi'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Kelas from '@/Components/Sia/Kelas'
import Proyek from '@/Components/Sia/Proyek'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getListDimensi from '@/Functions/getListDimensi'
import getSiswaWithNilaiProyek from '@/Functions/getSiswaWithNilaiProyek'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputNilaiProyek = ({ initTahun, listKelas, listProyek }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        kelasId: '',
        proyekId: '',
        dimensiId: '',
        listKategori: [],
        listDimensi: [],
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [message, setMessage] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaWithNilaiProyek(data.tahun, data.kelasId, data.proyekId, data.dimensiId)
        setListSiswa(response.listSiswa)
    }

    async function getDataDimensi() {
        const response = await getListDimensi(data.tahun, data.proyekId)
        setData({
            ...data,
            listDimensi: response.listDimensi
        })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('input-nilai-proyek.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Penilaian Proyek')
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
                text: "Hapus Nilai Proyek!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('input-nilai-proyek.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Penilaian Proyek')
                                setData({ ...data })
                                getDataSiswa()
                            }
                        }
                    )
            })
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, kelasId) => {

        const newList = [...listSiswa]
        newList.splice(index, 1, {
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: namaSiswa
            },
            penilaian_proyek: {
                id: id,
                nilai: e.target.value
            }
        })

        setMessage([])

        setListSiswa(newList)

        setCount(count + 1)

    }

    useEffect(() => {

        if (data.tahun && data.proyekId) {
            setData({ ...data, dimensiId: '' })
            trackPromise(getDataDimensi())
        }
    }, [data.tahun, data.proyekId])

    useEffect(() => {

        if (
            data.tahun
            && data.proyekId
            && data.dimensiId
            && data.kelasId
        ) {

            trackPromise(
                getDataSiswa()
            )
        } else {
            setListSiswa([])
        }


    }, [data.tahun, data.proyekId, data.dimensiId, data.kelasId])

    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })

    }, [count])

    return (
        <>
            <Head title='Input Nilai Proyek' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input nilai proyek</div>
            <div className='lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
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
                    handleChange={onHandleChange}
                    listKelas={listKelas}
                />

                <Proyek
                    id='proyekId'
                    name='proyekId'
                    value={data.proyekId}
                    message={errors.proyekId}
                    handleChange={onHandleChange}
                    listProyek={listProyek}
                />

                <Dimensi
                    id='dimensiId'
                    name='dimensiId'
                    value={data.dimensiId}
                    message={errors.dimensiId}
                    handleChange={onHandleChange}
                    listDimensi={data.listDimensi}
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
                                    <div className='flex flex-col'>
                                        <InputText
                                            id='penilaian'
                                            name='penilaian'
                                            message={errors.penilaian}
                                            className='w-auto max-w-[60px]'
                                            value={siswa.penilaian_proyek?.nilai ?? ''}
                                            handleChange={(e) => handleDynamic(e, index, siswa.penilaian_proyek?.id, siswa.nis, siswa.user.name, siswa.kelas_id)}
                                        />

                                        {message && message.nis == siswa.nis &&
                                            (
                                                <span className='text-emerald-500'>{message.message}</span>
                                            )}

                                        {data.arrayInput.length > 0 && data.arrayInput[index]?.penilaian_proyek?.nilai > 100 && (
                                            <span className='text-red-500'>Nilai Maksimal 100</span>
                                        )}

                                    </div>
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.penilaian_proyek?.nilai &&
                                        <Hapus
                                            onClick={() => handleDelete(siswa.penilaian_proyek?.id)}
                                        />
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className="flex justify-end pt-5">
                <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
            </div>
        </>
    )
}

InputNilaiProyek.layout = page => <AppLayout children={page} />
export default InputNilaiProyek