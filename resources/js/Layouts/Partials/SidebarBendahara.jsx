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
                <SidebarLink closeSide={closeSide} href={route('input-pembayaran-siswa')} active={route().current('input-pembayaran-siswa')} label='input pembayaran siswa' />
            </div>
        </div>
    )
}

export default SidebarBendahara