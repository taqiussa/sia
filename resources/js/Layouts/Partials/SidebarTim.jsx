import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarTim = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Tim Penilai
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('upload-nilai-karyawan')} active={route().current('upload-nilai-karyawan')} label='upload nilai' />
            </div>
        </div>
    )
}

export default SidebarTim