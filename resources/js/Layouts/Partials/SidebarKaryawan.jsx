import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKaryawan = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Karyawan
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('input-skor')} active={route().current('input-skor')} label='input skor' />
                <SidebarLink closeSide={closeSide} href={route('input-skor-kelas')} active={route().current('input-skor-kelas')} label='input skor 1 kelas' />
            </div>
        </div>
    )
}

export default SidebarKaryawan