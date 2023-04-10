import React from 'react'
import AppLayout from '@/Layouts/AppLayout';
import { Head } from '@inertiajs/react';

const Dashboard = () => {
    return (
        <>
            <Head title='Dashboard' />
            <div className='pl-10 pt-10 text-slate-600 text-lg'>Selamat Datang di Sistem Akademik SMP Al Musyaffa</div>
            <div className='pl-10 text-slate-600 text-lg'>Untuk Menggunakan sistem silahkan klik Menu di atas bagi yang menggunakan HP. Bagi yang menggunakan laptop atau komputer, menu berada di samping kiri</div>
        </>
    )
}
Dashboard.layout = page => <AppLayout children={page} title="Dashboard" />
export default Dashboard
