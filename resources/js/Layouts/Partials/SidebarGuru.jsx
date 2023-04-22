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
                <SidebarLink closeSide={closeSide} href={route('absensi-ujian')} active={route().current('absensi-ujian')} label='absensi ujian' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-alquran')} active={route().current('input-nilai-alquran')} label="input nilai al qur'an" />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-bilghoib-per-kelas')} active={route().current('input-nilai-bilghoib-per-kelas')} label='input nilai bilghoib per kelas' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-binnadzor-per-kelas')} active={route().current('input-nilai-binnadzor-per-kelas')} label='input nilai binnadzor per kelas' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-kelas')} active={route().current('print-absensi-kelas')} label='print absensi kelas' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-ujian')} active={route().current('print-absensi-ujian')} label='print absensi ujian' />
            </div>
        </div>
    )
}

export default SidebarGuru