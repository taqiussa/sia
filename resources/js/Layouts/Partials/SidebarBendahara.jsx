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
                <SidebarLink closeSide={closeSide} href={route('rekap-harian-pemasukan')} active={route().current('rekap-harian-pemasukan')} label='rekap harian pemasukan' />
            </div>
        </div>
    )
}

export default SidebarBendahara