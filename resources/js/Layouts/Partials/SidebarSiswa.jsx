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
                <SidebarLink closeSide={closeSide} href={route('alquran-bilghoib')} active={route().current('alquran-bilghoib')} label="al qur'an bilghoib" />
                <SidebarLink closeSide={closeSide} href={route('alquran-binnadzor')} active={route().current('alquran-binnadzor')} label="al qur'an binnadzor" />
                <SidebarLink closeSide={closeSide} href={route('data-bimbingan')} active={route().current('data-bimbingan')} label="data bimbingan" />
                <SidebarLink closeSide={closeSide} href={route('data-nilai')} active={route().current('data-nilai')} label="data nilai" />
                <SidebarLink closeSide={closeSide} href={route('data-skor')} active={route().current('data-skor')} label="data skor" />
            </div>
        </div>
    )
}

export default SidebarSiswa