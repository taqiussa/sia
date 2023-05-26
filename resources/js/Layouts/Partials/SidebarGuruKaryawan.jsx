import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarGuruKaryawan = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Guru & Karyawan
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('absensi-karyawan')} active={route().current('absensi-karyawan')} label='absensi karyawan' />
                <SidebarLink closeSide={closeSide} href={route('rekap-absensi-karyawan')} active={route().current('rekap-absensi-karyawan')} label='rekap absensi karyawan' />
                <SidebarLink closeSide={closeSide} href={route('slip-gaji')} active={route().current('slip-gaji')} label='slip gaji' />
            </div>
        </div>
    )
}

export default SidebarGuruKaryawan