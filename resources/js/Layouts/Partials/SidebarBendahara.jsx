import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarBendahara = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Bendahara
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('atur-kategori-pemasukan')} active={route().current('atur-kategori-pemasukan')} label='atur kategori pemasukan' />
                <SidebarLink closeSide={closeSide} href={route('atur-kategori-pengeluaran')} active={route().current('atur-kategori-pengeluaran')} label='atur kategori pengeluaran' />
                <SidebarLink closeSide={closeSide} href={route('atur-wajib-bayar')} active={route().current('atur-wajib-bayar')} label='atur wajib bayar' />
                <SidebarLink closeSide={closeSide} href={route('data-pemasukan')} active={route().current('data-pemasukan')} label='data pemasukan' />
                <SidebarLink closeSide={closeSide} href={route('data-pembayaran-siswa')} active={route().current('data-pembayaran-siswa')} label='data pembayaran siswa' />
                <SidebarLink closeSide={closeSide} href={route('data-pengeluaran')} active={route().current('data-pengeluaran')} label='data pengeluaran' />
                <SidebarLink closeSide={closeSide} href={route('input-pemasukan')} active={route().current('input-pemasukan')} label='input pemasukan' />
                <SidebarLink closeSide={closeSide} href={route('input-pembayaran-siswa')} active={route().current('input-pembayaran-siswa')} label='input pembayaran siswa' />
                <SidebarLink closeSide={closeSide} href={route('input-pengeluaran')} active={route().current('input-pengeluaran')} label='input pengeluaran' />
                <SidebarLink closeSide={closeSide} href={route('kas-bulanan')} active={route().current('kas-bulanan')} label='kas bulanan' />
                <SidebarLink closeSide={closeSide} href={route('kas-tahunan')} active={route().current('kas-tahunan')} label='kas tahunan' />
                <SidebarLink closeSide={closeSide} href={route('rekap-harian-pemasukan')} active={route().current('rekap-harian-pemasukan')} label='rekap harian pemasukan' />
                <SidebarLink closeSide={closeSide} href={route('rekap-harian-pengeluaran')} active={route().current('rekap-harian-pengeluaran')} label='rekap harian pengeluaran' />
                <SidebarLink closeSide={closeSide} href={route('rekap-penggajian')} active={route().current('rekap-penggajian')} label='rekap penggajian' />
                <SidebarLink closeSide={closeSide} href={route('rekap-per-siswa')} active={route().current('rekap-per-siswa')} label='rekap per siswa' />
                <SidebarLink closeSide={closeSide} href={route('rekap-tahunan-pemasukan')} active={route().current('rekap-tahunan-pemasukan')} label='rekap tahunan pemasukan' />
                <SidebarLink closeSide={closeSide} href={route('rekap-tahunan-pengeluaran')} active={route().current('rekap-tahunan-pengeluaran')} label='rekap tahunan pengeluaran' />
                <SidebarLink closeSide={closeSide} href={route('tagihan-per-kelas')} active={route().current('tagihan-per-kelas')} label='tagihan per kelas' />
                <SidebarLink closeSide={closeSide} href={route('upload-penggajian')} active={route().current('upload-penggajian')} label='upload penggajian' />
            </div>
        </div>
    )
}

export default SidebarBendahara