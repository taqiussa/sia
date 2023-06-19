import React, { useState } from 'react';
import Navbar from './Navbar';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Spinner from '@/Components/Sia/Spinner';
import moment from 'moment';
import SidebarNon from './SidebarNon';

export default function AppLayoutNon({ children }) {
    const [open, setOpen] = useState(false);
    const openSide = () => {
        setOpen(true);
    }

    const closeSide = () => {
        setOpen(false);
    }

    return (
        <>
            <Spinner />

            <ToastContainer theme='colored' />

            {/* Left Col */}
            <SidebarNon open={open} closeSide={closeSide} />
            {/* End Left Col */}

            {/*  Right Col  */}
            <div className="max-w-full ml-0 transition lg:ml-[310px] lg:max-w-7xl xl:max-w-full">
                {/*  NavBar  */}
                <Navbar openSide={openSide} />
                {/* End Navbar */}
                {/*  Main Content  */}
                <div className="px-2 py-2 container-fluid">
                    <main className='mb-20'>
                        {children}
                    </main>
                </div>
                <footer className='py-1 px-2 text-slate-600 bottom-0 fixed bg-white/30 backdrop-blur w-full'>
                    &copy; SMP Al Musyaffa 2022 - {moment(new Date()).format('YYYY')} | Developed By Kendali Koding
                </footer>
                {/* End Main Content */}
            </div>
            {/* End Right Col */}
        </>
    )
}
