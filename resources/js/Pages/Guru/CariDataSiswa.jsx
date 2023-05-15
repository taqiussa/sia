import InputText from '@/Components/Sia/InputText'
import Paginator from '@/Components/Sia/Paginator'
import Tahun from '@/Components/Sia/Tahun'
import getAllSiswaWithBiodata from '@/Functions/getAllSiswaWithBiodata'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import ReactPaginate from 'react-paginate'
import { trackPromise } from 'react-promise-tracker'

const CariDataSiswa = ({ initTahun }) => {

    const { data, setData } = useForm({
        tahun: initTahun,
        search: '',
        listSiswa: []
    })

    const [page, setPage] = useState(0);
    const postsPerPage = 10;
    const numberOfPostsVisited = page * postsPerPage;
    const totalPages = Math.ceil(data.listSiswa?.length / postsPerPage);
    const changePage = ({ selected }) => {
        setPage(selected);
    };

    const filteredData = data.listSiswa?.filter((list) => {
        const searchTerm = data.search.toLowerCase();
        const siswa = list.user?.name.toLowerCase();
        return (
            siswa.includes(searchTerm)
        );
    });

    async function getData() {
        const response = await getAllSiswaWithBiodata(data.tahun)
        setData({ ...data, listSiswa: response.listSiswa })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {
        if (data.tahun)
            trackPromise(getData())
    }, [data.tahun])

    return (
        <>
            <Head title='Cari Data Siswa' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">cari data siswa</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 grid grid-cols-2 gap-2 pb-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    handleChange={onHandleChange}
                />

                <InputText
                    id='search'
                    name='search'
                    value={data.search}
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
                                NIS
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                NISN
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Kelas
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Orang Tua
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Alamat
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.listSiswa &&
                            filteredData
                                .slice(numberOfPostsVisited, numberOfPostsVisited + postsPerPage)
                                .map((siswa, index) => (
                                    <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                        <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                            {index + 1 + (page * 10)}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {siswa.nis}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {siswa.user?.name}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {siswa.biodata?.nisn}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {siswa.kelas?.nama}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            {siswa.orang_tua?.nama_ayah}
                                        </td>
                                        <td className="py-2 px-2 font-medium text-slate-600">
                                            RT {siswa.alamat?.rt} RW {siswa.alamat?.rw}, Desa {siswa.alamat?.desa} - Kec. {siswa.alamat?.kecamatan}
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
                activeLinkClassName={"focus:shadow-outline transition-colors duration-150 bg-emerald-500 text-emerald-100 cursor-pointer"}
                /// end navigation styling ///
                renderOnZeroPageCount={null}
            />
        </>
    )
}

CariDataSiswa.layout = page => <AppLayout children={page} />
export default CariDataSiswa