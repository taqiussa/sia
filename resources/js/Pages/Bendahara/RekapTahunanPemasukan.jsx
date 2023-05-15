import PrintLink from '@/Components/Sia/PrintLink'
import PrintLinkMerah from '@/Components/Sia/PrintLinkMerah'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal, rupiah, tanggal } from '@/Functions/functions'
import getPemasukanTahunan from '@/Functions/getPemasukanTahunan'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import { toInteger } from 'lodash'
import React, { useEffect, useState } from 'react'
import ReactPaginate from 'react-paginate'
import { trackPromise } from 'react-promise-tracker'

const RekapTahunanPemasukan = ({ initTahun }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        listPemasukan: [],
        listPembayaran: [],
        subtotalPemasukan: [],
        subtotalPembayaran: [],
    })

    async function getData() {
        const response = await getPemasukanTahunan(data.tahun)
        setData({
            tahun: data.tahun,
            listPemasukan: response.listPemasukan,
            listPembayaran: response.listPembayaran,
            subtotalPemasukan: response.subtotalPemasukan,
            subtotalPembayaran: response.subtotalPembayaran
        })
    }

    // Pembayaran
    const [page, setPage] = useState(0);
    const postsPerPage = 10;
    const numberOfPostsVisited = page * postsPerPage;
    const totalPages = Math.ceil(data.listPembayaran?.length / postsPerPage);
    const changePage = ({ selected }) => {
        setPage(selected);
    };

    // Pemasukan
    const [pagePemasukan, setPagePemasukan] = useState(0);
    const postsPerPagePemasukan = 10;
    const numberOfPostsVisitedPemasukan = page * postsPerPagePemasukan;
    const totalPagesPemasukan = Math.ceil(data.listPemasukan?.length / postsPerPagePemasukan);
    const changePagePemasukan = ({ selected }) => {
        setPage(selected);
    };

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    useEffect(() => {
        if (data.tahun) {
            trackPromise(
                getData()
            )
        }
    }, [data.tahun])

    return (
        <>
            <Head title='Rekap Tahunan Pemasukan' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap tahunan pemasukan</div>
            <div className='lg:grid lg:grid-cols-5 lg:gap-2 lg:space-y-0 space-y-3'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <div className="flex items-end space-x-2">
                    <PrintLink
                        href={route('rekap-tahunan-pemasukan-simple', {
                            tahun: data.tahun
                        })}
                        label='print'
                    />
                    <PrintLinkMerah
                        href={route('rekap-tahunan-pemasukan-detail', {
                            tahun: data.tahun
                        })}
                        label='print detail'
                    />
                </div>

            </div>
            <div className="py-3 font-bold text-lg text-slate-600">
                Rekap Pembayaran Siswa
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
                                Siswa
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Gunabayar
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Tahun
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Bendahara
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listPembayaran &&
                            data.listPembayaran
                                .slice(numberOfPostsVisited, numberOfPostsVisited + postsPerPage)
                                .map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1 + (page * 10)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {tanggal(list.tanggal)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.siswa?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.kelas?.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.gunabayar?.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.tahun}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(list.jumlah)}
                                        </td>
                                    </tr>
                                ))}
                        <tr>
                            <td className="py-2 px-2 font-bold bg-slate-200 text-slate-600 text-lg" colSpan={7}>
                                Subtotal
                            </td>
                            <td className="py-2 px-2 font-bold bg-slate-200 text-slate-600 text-lg">
                                {rupiah(data.subtotalPembayaran)}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {
                data.listPembayaran.length > 0 &&
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
            }
            <div className="py-3 font-bold text-lg text-slate-600">Rekap Pemasukan</div>
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
                                Bendahara
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listPemasukan &&
                            data.listPemasukan
                                .slice(numberOfPostsVisitedPemasukan, numberOfPostsVisitedPemasukan + postsPerPagePemasukan)
                                .map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1}
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
                                            {list.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(list.jumlah)}
                                        </td>
                                    </tr>
                                ))}
                        <tr>
                            <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-200" colSpan={5}>
                                Subtotal
                            </td>
                            <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-200">
                                {rupiah(data.subtotalPemasukan)}
                            </td>
                        </tr>
                        <tr>
                            <td className="py-2 px-2 font-bold text-xl text-slate-600 bg-slate-300" colSpan={5}>
                                Total
                            </td>
                            <td className="py-2 px-2 font-bold text-xl text-slate-600 bg-slate-300">
                                {rupiah(toInteger(data.subtotalPemasukan) + toInteger(data.subtotalPembayaran))}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {
                data.listPemasukan.length > 0 &&
                <ReactPaginate
                    pageRangeDisplayed={3} //The range of buttons pages displayed.
                    previousLabel={"Previous"} //lable for previous page button
                    nextLabel={"Next"} // lable for Next page button
                    pageCount={totalPagesPemasukan} // place here the variable for total number of pages
                    onPageChange={changePagePemasukan} // place here the trigger event function
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
            }
        </>
    )
}

RekapTahunanPemasukan.layout = page => <AppLayout children={page} />
export default RekapTahunanPemasukan