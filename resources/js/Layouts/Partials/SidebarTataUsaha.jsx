import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarTataUsaha = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Tata Usaha
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('cari-data-siswa')} active={route().current('cari-data-siswa')} label='cari data siswa' />
                <SidebarLink closeSide={closeSide} href={route('download-qr-code')} active={route().current('download-qr-code')} label='download qr code' />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-alquran-tata-usaha')} active={route().current('print-nilai-alquran-tata-usaha')} label="print nilai al qur'an" />
                <SidebarLink closeSide={closeSide} href={route('rekap-pembayaran-siswa')} active={route().current('rekap-pembayaran-siswa')} label="rekap pembayaran siswa" />
            </div>
        </div>
    )
}

export default SidebarTataUsaha