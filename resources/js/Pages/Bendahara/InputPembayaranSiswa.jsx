import React, { useEffect, useRef, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import { arrayGunabayar, gunabayar, hariTanggal, rupiah } from '@/Functions/functions'
import { trackPromise } from 'react-promise-tracker'
import Sweet from '@/Components/Sia/Sweet'
import { toast } from 'react-toastify'
import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import moment from 'moment'
import SearchableSelect from '@/Components/Sia/SearchableSelect'
import getAllSiswa from '@/Functions/getAllSiswa'
import getPembayaranSiswa from '@/Functions/getPembayaranSiswa'
import Tanggal from '@/Components/Sia/Tanggal'
import { Icon } from '@mdi/react'
import { mdiCheckCircle } from '@mdi/js'
import Checkbox from '@/Components/Checkbox'
import PrintIcon from '@/Components/Sia/PrintIcon'

const InputPembayaranSiswa = ({ initTahun }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        jumlah: 0,
        total: 0,
        nis: '',
        dataSiswa: [],
        listPembayaran: [],
        listTransaksi: [],
        wajibBayar: 0,
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])

    const listGunabayar = arrayGunabayar()
    const optionsSiswa = listSiswa.map((siswa) => ({
        value: siswa.nis,
        label: `${siswa.user?.name} - ${siswa.kelas?.nama}`
    }))

    const checkboxRefs = useRef([])

    checkboxRefs.current = listGunabayar.map(
        (_, index) => checkboxRefs.current[index] || React.createRef()
    )

    async function getDataSiswa() {
        const response = await getAllSiswa(data.tahun)
        setListSiswa(response.listSiswa)
    }

    async function getDataPembayaranSiswa() {
        const response = await getPembayaranSiswa(data.tahun, data.nis)
        setData({
            ...data,
            dataSiswa: response.dataSiswa,
            listPembayaran: response.listPembayaran,
            wajibBayar: response.wajibBayar,
            jumlah: response.jumlah,
            listTransaksi: [],
            arrayInput: [],
        })
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

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
            listTransaksi: updatedArrayInput
        });
        const checkboxRef = checkboxRefs.current[index]
        checkboxRef.current.click()

    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('input-pembayaran-siswa.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Pembayaran Siswa')
                    setData({
                        ...data,
                        arrayInput: [],
                        listTransaksi: []
                    })
                    getDataPembayaranSiswa()
                    checkboxRefs.current.forEach((check) => {
                        if (check.current !== null)
                            check.current.checked = false
                    })
                },
                onError: (error) => {
                    Sweet.fire({
                        title: 'Gagal!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Kembali'
                    })
                }
            }
        )
    }
    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus Pembayaran Siswa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('input-pembayaran-siswa.hapus', { id: id, route: 'input-pembayaran-siswa' }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Pembayaran Siswa')
                                setData({
                                    ...data,
                                    listTransaksi: [],
                                    arrayInput: []
                                })
                                getDataPembayaranSiswa()
                            }
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
        if (data.tahun && data.nis) {
            trackPromise(
                getDataPembayaranSiswa()
            )
        }
    }, [data.tahun, data.nis])

    useEffect(() => {
        if (data.listTransaksi.length > 0) {
            setData('total', data.listTransaksi.length * data.jumlah)
        } else {
            setData('total', 0)
        }
    }, [data.listTransaksi])

    return (
        <>
            <Head title='Input Pembayaran Siswa' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">input pembayaran siswa</div>
            <form onSubmit={submit} className='space-y-3 mb-3'>
                <div className="grid grid-cols-2 gap-2">
                    <div className='space-y-3'>
                        <div className='grid grid-cols-2 gap-2'>
                            <Tahun
                                id='tahun'
                                name='tahun'
                                value={data.tahun}
                                message={errors.tahun}
                                handleChange={onHandleChange}
                            />

                            <Tanggal
                                id='tanggal'
                                name='tanggal'
                                label='tanggal'
                                value={data.tanggal}
                                message={errors.tanggal}
                                handleChange={onHandleChange}
                            />
                        </div>

                        <SearchableSelect
                            id="nis"
                            name="nis"
                            label="Siswa"
                            options={optionsSiswa}
                            value={data.nis}
                            message={errors.nis}
                            onChange={(e) => setData('nis', e)}
                        />
                        <div className='space-y-2'>
                            <div className='font-bold text-lg capitalize text-slate-600'>
                                data siswa
                            </div>
                            <table className="w-full text-sm text-slate-600">
                                <thead className="text-sm text-slate-600 bg-gray-50">
                                    <tr>
                                        <th scope='col' className="py-3 px-2">
                                            NIS
                                        </th>
                                        <th scope='col' className="py-3 px-2 text-left">
                                            Nama
                                        </th>
                                        <th scope='col' className="py-3 px-2 text-left">
                                            Kelas
                                        </th>
                                        <th scope='col' className="py-3 px-2 text-left">
                                            Desa
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {data.dataSiswa.nis}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {data.dataSiswa.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {data.dataSiswa.kelas?.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {data.dataSiswa.alamat?.desa}
                                        </td>
                                    </tr>
                                    <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-yellow-600" colSpan={3}>
                                            Wajib Bayar
                                        </td>
                                        <td className="py-2 px-2 font-medium text-yellow-600">
                                            {rupiah(data.wajibBayar)}
                                        </td>
                                    </tr>
                                    <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-emerald-600" colSpan={3}>
                                            Total Bayar
                                        </td>
                                        <td className="py-2 px-2 font-medium text-emerald-600">
                                            {rupiah(data.dataSiswa.totalBayar)}
                                        </td>
                                    </tr>
                                    <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-red-600" colSpan={3}>
                                            Kurang Bayar
                                        </td>
                                        <td className="py-2 px-2 font-medium text-red-600">
                                            {rupiah(data.wajibBayar - data.dataSiswa.totalBayar)}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <table className="w-full text-sm text-slate-600">
                            <thead className="text-sm text-slate-600 bg-gray-50">
                                <tr>
                                    <th scope='col' className="py-3 px-2">
                                        No
                                    </th>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Guna Bayar
                                    </th>
                                    <th scope='col' className="py-3 px-2 text-left">
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {data.listTransaksi && data.listTransaksi.map((transaksi, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {gunabayar(transaksi)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(data.jumlah)}
                                        </td>
                                    </tr>
                                ))}
                                <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-bold text-lg text-slate-600" colSpan={2}>
                                        Total
                                    </td>
                                    <td className="py-2 px-2 font-bold text-lg text-slate-600">
                                        {rupiah(data.total)}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <PrimaryButton onClick={submit} disabled={processing}>Simpan</PrimaryButton>
                    </div>
                </div>

            </form>
            <div className='font-bold text-lg text-slate-600 capitalize'>
                rincian pembayaran siswa
            </div>
            <div className="overflow-x-auto">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 bg-gray-50">
                        <tr>
                            <th scope='col' className="py-3 px-2">
                                No
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Guna Bayar
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tanggal
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jumlah
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Bendahara
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listGunabayar && listGunabayar.map((gunabayar, index) => (
                            <tr
                                key={index}
                                onClick={() => {
                                    const checkboxRef = checkboxRefs.current[index]
                                    checkboxRef.current.click()
                                }}
                                className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 uppercase">
                                    {gunabayar.nama}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.dataSiswa.pembayarans && data.dataSiswa.pembayarans
                                        .filter((bayar) => bayar.gunabayar_id == gunabayar.id)
                                        .map((bayar, index) => (
                                            <div key={index}>{hariTanggal(bayar.tanggal)}</div>
                                        ))}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.dataSiswa.pembayarans && data.dataSiswa.pembayarans
                                        .filter((bayar) => bayar.gunabayar_id == gunabayar.id)
                                        .map((bayar, index) => (
                                            <div key={index}>{rupiah(bayar.jumlah)}</div>
                                        ))}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.dataSiswa.pembayarans && data.dataSiswa.pembayarans
                                        .filter((bayar) => bayar.gunabayar_id == gunabayar.id)
                                        .map((bayar, index) => (
                                            <div key={index}>{bayar.user?.name}</div>
                                        ))}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {data.dataSiswa.pembayarans && data.dataSiswa.pembayarans
                                        .some((bayar) => bayar.gunabayar_id == gunabayar.id) ?
                                        (
                                            <div className='text-emerald-600'>
                                                <Icon path={mdiCheckCircle} size={1} />
                                            </div>
                                        )
                                        :
                                        data.nis && (
                                            <div>
                                                <Checkbox
                                                    ref={checkboxRefs.current[index]}
                                                    name={gunabayar.id}
                                                    value={gunabayar.id}
                                                    handleChange={(e) => handleDynamic(e, index)} />
                                            </div>
                                        )
                                    }
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className='font-bold text-lg text-slate-600 capitalize mt-5'>
                data pembayaran siswa
            </div>
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
                                Jumlah
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Bendahara
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listPembayaran && data.listPembayaran.map((bayar, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {hariTanggal(bayar.tanggal)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {rupiah(bayar.jumlah)}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {bayar.user?.name}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    <div className="flex space-x-3">
                                        <PrintIcon href={route('kwitansi',
                                            {
                                                id: bayar.id,
                                                tahun: data.tahun,
                                                nis: data.nis
                                            })}
                                        />
                                        <Hapus onClick={() => handleDelete(bayar.id)} />
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    )

}

InputPembayaranSiswa.layout = page => <AppLayout children={page} />
export default InputPembayaranSiswa
