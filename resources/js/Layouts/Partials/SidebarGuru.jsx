import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarGuru = ({closeSide}) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Guru
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('absensi')} active={route().current('absensi')} label='absensi' />
            </div>
        </div>
    )
}

export default SidebarGuru