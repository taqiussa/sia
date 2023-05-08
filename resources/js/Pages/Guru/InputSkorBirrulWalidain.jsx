import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Kelas from '@/Components/Sia/Kelas'
import Paginator from '@/Components/Sia/Paginator'
import SearchableSelect from '@/Components/Sia/SearchableSelect'
import Semester from '@/Components/Sia/Semester'
import Siswa from '@/Components/Sia/Siswa'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal } from '@/Functions/functions'
import getDataKelasWaliKelas from '@/Functions/getDataKelasWaliKelas'
import getSiswa from '@/Functions/getSiswa'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm, usePage } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputSkor = ({ initTahun, initSemester, listData, listKelas, listSkor }) => {

    const { auth } = usePage().props

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        semester: initSemester,
        nis: '',
        skorId: '',
        jumlah: 1,
        kelasId: '',
    })

    const [listSiswa, setListSiswa] = useState([])

    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    async function getData() {
        const response = await getDataKelasWaliKelas(data.tahun)
        setData('kelasId', response.kelasId)
    }

    const optionSkor = listSkor.map((skor) => ({
        value: skor.id,
        label: `(${skor.skor}) ${skor.keterangan}`
    }))

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(
            route('input-skor-birrul-walidain.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Skor')
                    setData({
                        tanggal: data.tanggal,
                        tahun: data.tahun,
                        semester: data.semester,
                        kelasId: data.kelasId,
                        nis: data.nis,
                        jumlah: data.jumlah,
                        skorId: data.skorId
                    })

                    getDataSkor()
                }
            }
        )
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
                        route('input-skor-birrul-walidain.hapus',
                            {
                                id: id,
                                tahun: data.tahun,
                                kelasId: data.kelasId
                            }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Skor Siswa')
                                setData({
                                    tanggal: data.tanggal,
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    kelasId: data.kelasId,
                                    nis: data.nis,
                                    jumlah: data.jumlah,
                                    skorId: data.skorId
                                })

                                getDataSkor()
                            }
                        }
                    )
            })
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getData()
            )
    }, [])

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getData()
            )
    }, [data.tahun])

    useEffect(() => {

        if (data.tahun && data.kelasId
        ) {

            trackPromise(
                getDataSiswa()
            )

            router.reload(
                {
                    only: ['listData'],
                    data: {
                        tahun: data.tahun,
                        kelasId: data.kelasId,
                    },
                    preserveState: true,
                    replace: true
                }
            )

        }
        else {
            setListSiswa([])
        }
    }, [data.tahun, data.kelasId])

    return (
        <>
            <Head title='Input Skor Birrul Walidain' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">input skor birrul walidain</div>
            <form onSubmit={submit}>
                <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 mb-2'>
                    <Tanggal
                        id='tanggal'
                        name='tanggal'
                        label='tanggal'
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
                <div className="mt-2">
                    <Siswa
                        id='nis'
                        name='nis'
                        value={data.nis}
                        message={errors.nis}
                        handleChange={onHandleChange}
                        listSiswa={listSiswa}
                    />
                </div>

                <div className="lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-2 my-2">
                    <InputText
                        id='jumlah'
                        name='jumlah'
                        label='jumlah melakukan'
                        value={data.jumlah}
                        message={errors.jumlah}
                        handleChange={onHandleChange}
                    />
                    <div className="col-span-3">
                        <SearchableSelect
                            id='skorId'
                            name='skorId'
                            label='pilih skor'
                            options={optionSkor}
                            value={data.skorId}
                            message={errors.skorId}
                            onChange={(e) => setData('skorId', e)}
                        />
                    </div>
                </div>
                <div>
                    <PrimaryButton
                        onClick={submit}
                        children='simpan'
                        disabled={processing}
                    />
                </div>
            </form>
            <div className="overflow-x-auto">
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
                        {listData &&
                            listData.data.map((list, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1 + ((listData.current_page - 1) * listData.per_page)}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {hariTanggal(list.tanggal)}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.siswa?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.skors?.keterangan}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.skor}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {list.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                        {list.user.id == auth.user.id && <Hapus
                                            onClick={() => handleDelete(list.id)}
                                        />}
                                    </td>
                                </tr>
                            ))}
                    </tbody>
                </table>
            </div>
            <Paginator lists={listData} />
        </>
    )
}

InputSkor.layout = page => <AppLayout children={page} />
export default InputSkor