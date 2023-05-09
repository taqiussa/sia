import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKetenagaan = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Ketenagaan
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('jadwal-jam-kosong')} active={route().current('jadwal-jam-kosong')} label='jadwal jam kosong' />
                <SidebarLink closeSide={closeSide} href={route('permintaan-badal')} active={route().current('permintaan-badal')} label='permintaan badal' />
            </div>
        </div>
    )
}

export default SidebarKetenagaan