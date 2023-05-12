import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, rupiah } from '@/Functions/functions'
import getPengeluaran from '@/Functions/getPengeluaran'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import ReactPaginate from 'react-paginate'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const DataPengeluaran = ({ initTahun }) => {

    const { data, setData, errors, delete: destroy } = useForm({
        tahun: initTahun,
        search: ''
    })

    const [listPengeluaran, setListPengeluaran] = useState([])

    const [page, setPage] = useState(0);
    const postsPerPage = 10;
    const numberOfPostsVisited = page * postsPerPage;
    const totalPages = Math.ceil(listPengeluaran?.length / postsPerPage);
    const changePage = ({ selected }) => {
        setPage(selected);
    };

    const filteredData = listPengeluaran?.filter((list) => {
        const searchTerm = data.search.toLowerCase();
        const keterangan = list.keterangan.toLowerCase();
        return (
            keterangan.includes(searchTerm)
        );
    });

    async function getData() {
        const response = await getPengeluaran(data.tahun)
        setListPengeluaran(response.listPengeluaran)
    }

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda Yakin Menghapus ?',
                text: 'Hapus pengeluaran',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    destroy(
                        route('input-pengeluaran.hapus', {
                            id: id,
                            route: 'data-pengeluaran'
                        }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus pengeluaran')
                                setData({
                                    tahun: data.tahun,
                                    search: data.search
                                })
                            }
                        }
                    )
                }
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

    return (
        <>
            <Head title='Data Pengeluaran' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">data pengeluaran</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    label='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <InputText
                    id='search'
                    name='search'
                    value={data.search}
                    message={errors.search}
                    label='search'
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
                                Kategori
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
                        {listPengeluaran &&
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
                activeLinkClassName={"focus:shadow-outline transition-colors duration-150 bg-emerald-500 font-bold cursor-pointer"}
                /// end navigation styling ///
                renderOnZeroPageCount={null}
            />
        </>
    )
}

DataPengeluaran.layout = page => <AppLayout children={page} />
export default DataPengeluaran