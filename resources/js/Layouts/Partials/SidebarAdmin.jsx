import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarAdmin = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Admin
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('upload-siswa')} active={route().current('upload-siswa')} label='upload siswa' />
            </div>
        </div>
    )
}

export default SidebarAdmin