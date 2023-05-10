import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKonseling = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Konseling
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('cek-list-absensi')} active={route().current('cek-list-absensi')} label='cek list absensi' />
            </div>
        </div>
    )
}

export default SidebarKonseling