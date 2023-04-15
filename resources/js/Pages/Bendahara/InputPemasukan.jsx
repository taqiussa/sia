import PrimaryButton from '@/Components/PrimaryButton'
import Hapus from '@/Components/Sia/Hapus'
import InputArea from '@/Components/Sia/InputArea'
import InputText from '@/Components/Sia/InputText'
import KategoriPemasukan from '@/Components/Sia/KategoriPemasukan'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import Tanggal from '@/Components/Sia/Tanggal'
import { hariTanggal, maskRupiah, rupiah } from '@/Functions/functions'
import getPemasukan from '@/Functions/getPemasukan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'
import { useState } from 'react'
import ReactPaginate from 'react-paginate'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputPemasukan = ({ initTahun, listKategoriPemasukan }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        kategoriPemasukanId: '',
        keterangan: '',
        jumlah: 0,
        cari: ''
    })

    const [listPemasukan, setListPemasukan] = useState([])

    const [page, setPage] = useState(0);
    const postsPerPage = 10;
    const numberOfPostsVisited = page * postsPerPage;
    const totalPages = Math.ceil(listPemasukan?.length / postsPerPage);
    const changePage = ({ selected }) => {
        setPage(selected);
    };


    const filteredData = listPemasukan?.filter((list) => {
        const searchTerm = data.cari.toLowerCase();
        const keterangan = list.keterangan.toLowerCase();
        return (
            keterangan.includes(searchTerm)
        );
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleRupiah = (e) => {
        const value = e.target.value
        setData('jumlah', maskRupiah(value))
    }

    async function getDataPemasukan() {
        const response = await getPemasukan(data.tahun)
        setListPemasukan(response.listPemasukan)
    }

    const submit = (e) => {
        e.preventDefault()
        post(route('input-pemasukan.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Pemasukan')
                    setData({
                        tahun: data.tahun,
                        tanggal: data.tanggal,
                        kategoriPemasukanId: '',
                        keterangan: '',
                        jumlah: 0,
                        cari: data.cari
                    })
                    getDataPemasukan()
                },
                onError: (error) => {
                    Sweet.fire({
                        title: 'Gagal!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'Kembali'
                    })
                }
            })
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda Yakin Menghapus ?',
                text: 'Hapus Pemasukan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(
                        route('input-pemasukan.hapus', {
                            id: id
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Pemasukan')
                                setData({
                                    tahun: data.tahun,
                                    tanggal: data.tanggal,
                                    kategoriPemasukanId: '',
                                    keterangan: '',
                                    jumlah: '',
                                    cari: data.cari
                                })
                                getDataPemasukan()
                            }
                        }
                    )
                }
            })
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getDataPemasukan()
            )
    }, [])

    useEffect(() => {
        if (data.tahun)
            trackPromise(
                getDataPemasukan()
            )
    }, [data.tahun])
    return (
        <>
            <Head title='Input Pemasukan' />
            <form onSubmit={submit} className='space-y-3 mb-3'>

                <div className='lg:grid lg:grid-cols-3 lg:gap-2 lg:space-y-0 space-y-3'>

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
                        label='tahun'
                        value={data.tahun}
                        message={errors.tahun}
                        handleChange={onHandleChange}
                    />

                    <KategoriPemasukan
                        id='kategoriPemasukanId'
                        name='kategoriPemasukanId'
                        value={data.kategoriPemasukanId}
                        message={errors.kategoriPemasukanId}
                        listKategori={listKategoriPemasukan}
                        handleChange={onHandleChange}
                    />
                </div>

                <div className='lg:grid lg:grid-cols-2 lg:gap-2 lg:space-y-0 space-y-3'>

                    <InputArea
                        id='keterangan'
                        name='keterangan'
                        label='keterangan'
                        rows={2}
                        value={data.keterangan}
                        message={errors.keterangan}
                        handleChange={onHandleChange}
                    />

                    <InputText
                        id='jumlah'
                        name='jumlah'
                        label='jumlah'
                        value={data.jumlah}
                        message={errors.jumlah}
                        handleChange={handleRupiah}
                    />

                </div>

                <PrimaryButton type='submit' children='simpan' />
            </form>
            <div className='lg:grid lg:grid-cols-3'>
                <InputText
                    id='cari'
                    name='cari'
                    value={data.cari}
                    message={errors.cari}
                    label='cari'
                    handleChange={onHandleChange}
                />
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
                                Kategori Pemasukan
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Keterangan
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
                        {listPemasukan &&
                            filteredData
                                .slice(numberOfPostsVisited, numberOfPostsVisited + postsPerPage)
                                .map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1 + (page * 10)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {hariTanggal(list.tanggal)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.kategori?.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.keterangan}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(list.jumlah)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                                            <Hapus
                                                onClick={() => handleDelete(list.id)}
                                            />
                                        </td>
                                    </tr>
                                ))}
                    </tbody>
                </table>
            </div>
            <section className="my-2 overflow-x-auto">
                <ReactPaginate
                    pageRangeDisplayed={3} //The range of buttons pages displayed.
                    previousLabel={"Previous"} //lable for previous page button
                    nextLabel={"Next"} // lable for Next page button
                    pageCount={totalPages} // place here the variable for total number of pages
                    onPageChange={changePage} // place here the trigger event function
                    /// navigation CSS styling ///
                    containerClassName={"flex items-center my-4 space-x-1 text-slate-600"}
                    pageLinkClassName={"focus:shadow-outline transition-colors duration-150 border-emerald-500 hover:bg-emerald-300 rounded-md py-1 px-2 border"}
                    previousLinkClassName={"focus:shadow-outline transition-colors duration-150 border-emerald-500 hover:bg-emerald-300 rounded-l-md py-1 px-2 border"}
                    nextLinkClassName={"focus:shadow-outline transition-colors duration-150 border-emerald-500 hover:bg-emerald-300 rounded-r-md py-1 px-2 border"}
                    disabledLinkClassName={"text-gray-300 cursor-not-allowed hover:bg-white"}
                    activeLinkClassName={"focus:shadow-outline transition-colors duration-150 bg-emerald-500 text-emerald-100 cursor-pointer"}
                    /// end navigation styling ///
                    renderOnZeroPageCount={null}
                />
            </section>
        </>
    )
}

InputPemasukan.layout = page => <AppLayout children={page} />
export default InputPemasukan