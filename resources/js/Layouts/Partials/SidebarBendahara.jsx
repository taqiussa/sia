import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarBendahara = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Transaksi
            </div>
            <SidebarLink closeSide={closeSide} href={route('input-pemasukan')} active={route().current('input-pemasukan')} label='input pemasukan' />
            <SidebarLink closeSide={closeSide} href={route('input-pembayaran-siswa')} active={route().current('input-pembayaran-siswa')} label='input pembayaran siswa' />
            <SidebarLink closeSide={closeSide} href={route('input-pengeluaran')} active={route().current('input-pengeluaran')} label='input pengeluaran' />
            <div className='text-slate-600 font-bold'>
                Kas
            </div>
            <SidebarLink closeSide={closeSide} href={route('kas-bulanan')} active={route().current('kas-bulanan')} label='kas bulanan' />
            <SidebarLink closeSide={closeSide} href={route('kas-tahunan')} active={route().current('kas-tahunan')} label='kas tahunan' />
            <div className='text-slate-600 font-bold'>
                Pengaturan
            </div>
            <SidebarLink closeSide={closeSide} href={route('atur-kategori-pemasukan')} active={route().current('atur-kategori-pemasukan')} label='atur kategori pemasukan' />
            <SidebarLink closeSide={closeSide} href={route('atur-kategori-pengeluaran')} active={route().current('atur-kategori-pengeluaran')} label='atur kategori pengeluaran' />
            <SidebarLink closeSide={closeSide} href={route('atur-wajib-bayar')} active={route().current('atur-wajib-bayar')} label='atur wajib bayar' />
            <div className='text-slate-600 font-bold'>
                Penggajian
            </div>
            <SidebarLink closeSide={closeSide} href={route('rekap-penggajian')} active={route().current('rekap-penggajian')} label='rekap penggajian' />
            <SidebarLink closeSide={closeSide} href={route('rekap-transport-total')} active={route().current('rekap-transport-total')} label='rekap total transport' />
            <SidebarLink closeSide={closeSide} href={route('upload-penggajian')} active={route().current('upload-penggajian')} label='upload penggajian' />
            <div className='text-slate-600 font-bold'>
                Rekap Pemasukan
            </div>
            <SidebarLink closeSide={closeSide} href={route('data-pemasukan')} active={route().current('data-pemasukan')} label='data pemasukan' />
            <SidebarLink closeSide={closeSide} href={route('data-pembayaran-siswa')} active={route().current('data-pembayaran-siswa')} label='data pembayaran siswa' />
            <SidebarLink closeSide={closeSide} href={route('rekap-harian-pemasukan')} active={route().current('rekap-harian-pemasukan')} label='rekap harian pemasukan' />
            <SidebarLink closeSide={closeSide} href={route('rekap-tahunan-pemasukan')} active={route().current('rekap-tahunan-pemasukan')} label='rekap tahunan pemasukan' />
            <div className='text-slate-600 font-bold'>
                Rekap Pengeluaran
            </div>
            <SidebarLink closeSide={closeSide} href={route('data-pengeluaran')} active={route().current('data-pengeluaran')} label='data pengeluaran' />
            <SidebarLink closeSide={closeSide} href={route('rekap-harian-pengeluaran')} active={route().current('rekap-harian-pengeluaran')} label='rekap harian pengeluaran' />
            <div className='text-slate-600 font-bold'>
                <SidebarLink closeSide={closeSide} href={route('rekap-tahunan-pengeluaran')} active={route().current('rekap-tahunan-pengeluaran')} label='rekap tahunan pengeluaran' />
                Siswa
            </div>
            <SidebarLink closeSide={closeSide} href={route('rekap-per-siswa')} active={route().current('rekap-per-siswa')} label='rekap per siswa' />
            <SidebarLink closeSide={closeSide} href={route('tagihan-per-kelas')} active={route().current('tagihan-per-kelas')} label='tagihan per kelas' />
        </div>
    )
}

export default SidebarBendahara