import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKonseling = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Konseling
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('bimbingan-individu')} active={route().current('bimbingan-individu')} label='bimbingan individu' />
                <SidebarLink closeSide={closeSide} href={route('cari-data-siswa')} active={route().current('cari-data-siswa')} label='cari data siswa' />
                <SidebarLink closeSide={closeSide} href={route('cek-list-absensi')} active={route().current('cek-list-absensi')} label='cek list absensi' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-kelas')} active={route().current('print-absensi-kelas')} label='print absensi kelas' />
                <SidebarLink closeSide={closeSide} href={route('rekap-bimbingan')} active={route().current('rekap-bimbingan')} label='rekap bimbingan' />
                <SidebarLink closeSide={closeSide} href={route('rekap-kehadiran')} active={route().current('rekap-kehadiran')} label='rekap kehadiran' />
                <SidebarLink closeSide={closeSide} href={route('rekap-skor')} active={route().current('rekap-skor')} label='rekap skor' />
            </div>
        </div>
    )
}

export default SidebarKonseling