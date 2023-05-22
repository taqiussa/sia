import Checkbox from '@/Components/Checkbox'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Kelas from '@/Components/Sia/Kelas'
import SearchableSelect from '@/Components/Sia/SearchableSelect'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal } from '@/Functions/functions'
import getSiswa from '@/Functions/getSiswa'
import getSkorKelas from '@/Functions/getSkorKelas'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect, useRef, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputSkorKelas = ({ initTahun, initSemester, listSkor, listKelas }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        semester: initSemester,
        nis: '',
        skorId: '',
        kelasId: '',
        jumlah: 1,
        listData: [],
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    async function getDataSiswa() {
        const response = await getSiswa(data.tahun, data.kelasId)
        setListSiswa(response.listSiswa)
    }

    async function getDataSkor() {
        const response = await getSkorKelas(data.tanggal, data.kelasId)
        setData({ ...data, listData: response.listData })
    }

    const optionSkor = listSkor.map((skor) => ({
        value: skor.id,
        label: `(${skor.skor}) ${skor.keterangan}`
    }))

    const checkboxRefs = useRef([])

    checkboxRefs.current = listSiswa.map(
        (_, index) => checkboxRefs.current[index] || React.createRef()
    )

    const handleDynamic = (e, index) => {
        const { value, checked } = e.target;
        let updatedArrayInput = [...data.arrayInput];
        if (checked) {
            updatedArrayInput.push(value);
        } else {
            updatedArrayInput = updatedArrayInput.filter(item => item !== value);
        }
        setData({
            ...data,
            arrayInput: updatedArrayInput,
        });

    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault()

        post(
            route('input-skor-kelas.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Skor')
                    setData({
                        ...data,
                        arrayInput: []
                    })
                    checkboxRefs.current.forEach((check) => {
                        if (check.current !== null)
                            check.current.checked = false
                    })
                    trackPromise(getDataSkor())
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
                        route('input-skor-kelas.hapus',
                            {
                                id: id
                            }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Skor Siswa')
                                setData({
                                    ...data,
                                    arrayInput: []
                                })
                                trackPromise(getDataSkor())
                            }
                        }
                    )
            })
    }

    useEffect(() => {
        trackPromise(
            getDataSkor(),
            getDataSiswa()
        )
    }, [data.tanggal, data.tahun, data.kelasId])

    return (
        <>
            <Head title='Input Skor' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">input skor</div>

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
                />

            </div>

            <div className="mt-2 lg:grid lg:grid-cols-4 lg:gap-2">
                <div>
                    <InputText
                        id='jumlah'
                        name='jumlah'
                        label='jumlah melakukan'
                        value={data.jumlah}
                        message={errors.jumlah}
                        handleChange={onHandleChange}
                    />
                </div>
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

            <div className="mt-2">
                <PrimaryButton
                    onClick={submit}
                    children='simpan'
                    disabled={processing}
                />
            </div>

            <div className="overflow-x-auto pt-2">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                {/* <Checkbox
                                    value='all'
                                    checked={selectAll}
                                    handleChange={handleSelectAllChange}
                                /> */}
                            </th>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa.map((siswa, index) => (
                            <tr
                                key={index}
                                onClick={() => {
                                    const checkboxRef = checkboxRefs.current[index]
                                    checkboxRef.current.click()
                                }}
                                className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    <Checkbox
                                        ref={checkboxRefs.current[index]}
                                        name={siswa.nis}
                                        value={siswa.nis}
                                        handleChange={(e) => handleDynamic(e, index)}
                                    />
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.user.name}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
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
                        {data.listData && data.listData.map((dataSkor, index) => (
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

InputSkorKelas.layout = page => <AppLayout children={page} />
export default InputSkorKelas