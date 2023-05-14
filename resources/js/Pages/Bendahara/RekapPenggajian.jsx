import Bulan from '@/Components/Sia/Bulan'
import Tahun from '@/Components/Sia/Tahun'
import { rupiah } from '@/Functions/functions'
import getPenggajian from '@/Functions/getPenggajian'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect, useState } from 'react'
import ReactPaginate from 'react-paginate'
import { trackPromise } from 'react-promise-tracker'

const RekapPenggajian = ({ initTahun }) => {

    const { data, setData, errors } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM'),
        listPenggajian: [],
        total: 0
    })

    async function getData() {
        const response = await getPenggajian(data.tahun, data.bulan)
        setData({
            tahun: data.tahun,
            bulan: data.bulan,
            listPenggajian: response.listPenggajian,
            total: response.total
        })
    }

    const [page, setPage] = useState(0);
    const postsPerPage = 10;
    const numberOfPostsVisited = page * postsPerPage;
    const totalPages = Math.ceil(data.listPenggajian?.length / postsPerPage);
    const changePage = ({ selected }) => {
        setPage(selected);
    };

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.bulan) {
            trackPromise(
                getData()
            )
        }

    }, [data.tahun, data.bulan])
    return (
        <>
            <Head title='Rekap Penggajian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap penggajian</div>

            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-2'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    id='bulan'
                    name='bulan'
                    value={data.bulan}
                    message={errors.bulan}
                    handleChange={onHandleChange}
                />

            </div>
            <div className='overflow-x-auto space-y-7'>
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
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listPenggajian &&
                            data.listPenggajian
                                .slice(numberOfPostsVisited, numberOfPostsVisited + postsPerPage)
                                .map((list, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1 + (page * 10)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {list.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {rupiah(list.penggajian?.jumlah_terima)}
                                        </td>
                                    </tr>
                                ))}
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-slate-600 font-bold text-lg bg-slate-300 capitalize" colSpan={2}>
                                total
                            </td>
                            <td className="py-2 px-2 font-bold text-lg text-slate-600 bg-slate-300">
                                {rupiah(data.total)}
                            </td>
                        </tr>
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
                activeLinkClassName={"focus:shadow-outline transition-colors duration-150 bg-emerald-500 text-emerald-100 cursor-pointer"}
                /// end navigation styling ///
                renderOnZeroPageCount={null}
            />
        </>
    )
}

RekapPenggajian.layout = page => <AppLayout children={page} />
export default RekapPenggajian