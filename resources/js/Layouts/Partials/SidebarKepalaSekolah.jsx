import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKepalaSekolah = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Kepala Sekolah
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('hasil-penilaian-guru')} active={route().current('hasil-penilaian-guru')} label='hasil penilaian guru' />
                <SidebarLink closeSide={closeSide} href={route('rekap-sosial')} active={route().current('rekap-sosial')} label='rekap sosial' />
                <SidebarLink closeSide={closeSide} href={route('total-sosial')} active={route().current('total-sosial')} label='total sosial' />
            </div>
        </div>
    )
}

export default SidebarKepalaSekolah