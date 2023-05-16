import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarSiswa = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Siswa
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('administrasi')} active={route().current('administrasi')} label='administrasi' />
            </div>
        </div>
    )
}

export default SidebarSiswa