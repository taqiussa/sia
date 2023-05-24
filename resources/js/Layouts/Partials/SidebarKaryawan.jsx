import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKaryawan = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Karyawan
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('download-qr-code')} active={route().current('download-qr-code')} label='download qr code' />
            </div>
        </div>
    )
}

export default SidebarKaryawan