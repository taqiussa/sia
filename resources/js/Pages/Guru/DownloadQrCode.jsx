import AppLayout from '@/Layouts/AppLayout';
import React, { useState } from 'react';
import QRCode from 'qrcode';
import { Head } from '@inertiajs/react';
import ReactPaginate from 'react-paginate';
import PrimaryButton from '@/Components/PrimaryButton';

const DownloadQrCode = ({ listUser }) => {

    const [page, setPage] = useState(0);
    const postsPerPage = 10;
    const numberOfPostsVisited = page * postsPerPage;
    const totalPages = Math.ceil(listUser.length / postsPerPage);
    const changePage = ({ selected }) => {
        setPage(selected);
    };

    const downloadQRCode = async (data, width, height) => {
        try {
            const qrCodeUrl = await QRCode.toDataURL(data.id.toString(), { width, height });
            const downloadLink = document.createElement('a');
            downloadLink.href = qrCodeUrl;
            downloadLink.download = `${data.name}.png`; // Access the name property of the data object
            downloadLink.click();
        } catch (error) {
            console.error('Error generating QR code:', error);
        }
    };

    return (
        <>
            <Head title='Download QR Code' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">download qr code</div>

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
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {listUser &&
                            listUser
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
                                            <PrimaryButton
                                                onClick={() => downloadQRCode(list, 400, 400)}
                                                children='download' />
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
    );
};

DownloadQrCode.layout = (page) => <AppLayout children={page} />;
export default DownloadQrCode;
