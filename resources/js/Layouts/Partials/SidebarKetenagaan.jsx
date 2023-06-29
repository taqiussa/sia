import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKetenagaan = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Ketenagaan
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('atur-khusus-pulang')} active={route().current('atur-khusus-pulang')} label='atur khusus pulang' />
                <SidebarLink closeSide={closeSide} href={route('atur-pulang-awal')} active={route().current('atur-pulang-awal')} label='atur pulang awal' />
                <SidebarLink closeSide={closeSide} href={route('jadwal-jam-kosong')} active={route().current('jadwal-jam-kosong')} label='jadwal jam kosong' />
                <SidebarLink closeSide={closeSide} href={route('list-badal')} active={route().current('list-badal')} label='list badal' />
                <SidebarLink closeSide={closeSide} href={route('permintaan-badal')} active={route().current('permintaan-badal')} label='permintaan badal' />
                <SidebarLink closeSide={closeSide} href={route('rekap-harian-absensi-karyawan')} active={route().current('rekap-harian-absensi-karyawan')} label='rekap harian absensi' />
                <SidebarLink closeSide={closeSide} href={route('rekap-jam-kosong')} active={route().current('rekap-jam-kosong')} label='rekap jam kosong' />
            </div>
        </div>
    )
}

export default SidebarKetenagaan