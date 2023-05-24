import Sweet from '@/Components/Sia/Sweet'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useState } from 'react'
import { QrScanner } from '@yudiel/react-qr-scanner'
import ReactPaginate from 'react-paginate'

const AbsensiKaryawan = ({ listAbsensi }) => {

    const { data, setData, post, errors, processing } = useForm({
        id: '',
        pilihan: 'Masuk'
    })

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

    const submit = (e) => {

        setData({ ...data, id: e })
        post(route('absensi-karyawan.simpan'),
            {
                onSuccess: (e) => {
                    Sweet.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: `Berhasil Absen ${data.pilihan}`,
                    })
                },
                onError: () => {
                    Sweet.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `Sudah Absen ${data.pilihan}`,
                    })
                }
            })
    }

    return (
        <>
            <Head title='Absensi Guru dan Karyawan' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 bg-emerald-200">absensi guru dan karyawan</div>


            <div className='lg:grid lg:grid-cols-3 lg:gap-2 lg:space-y-0 py-2'>
                <div>
                    <select
                        name='pilihan'
                        id='piihan'
                        value={data.pilihan}
                        className='border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full text-slate-600'
                        onChange={onHandleChange}
                    >

                        <option value="">Pilih</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Pulang">Pulang</option>

                    </select>
                </div>
            </div>
            <div className=' flex justify-center items-center text-center py-2 max-w-md'>
                <QrScanner
                    onDecode={(e) => submit(e)}
                    onError={(error) => console.log(error?.message)}
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
                                Nama
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Masuk
                            </th>
                            <th scope='col' className="py-3 px-2 text-left">
                                Pulang
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listAbsensi && listAbsensi
                            .slice(numberOfPostsVisited, numberOfPostsVisited + postsPerPage)
                            .map((absensi, index) => (
                                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                    <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                        {index + 1}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {absensi.user?.name}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {absensi.masuk ? new Date(absensi.masuk).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : null}
                                    </td>
                                    <td className="py-2 px-2 font-medium text-slate-600">
                                        {absensi.pulang ? new Date(absensi.pulang).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : null}
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

AbsensiKaryawan.layout = page => <AppLayout children={page} />
export default AbsensiKaryawan