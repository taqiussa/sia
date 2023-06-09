import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKurikulum = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Kurikulum
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('atur-nama-dimensi')} active={route().current('atur-nama-dimensi')} label='atur nama dimensi' />
                <SidebarLink closeSide={closeSide} href={route('atur-nama-elemen')} active={route().current('atur-nama-elemen')} label='atur nama elemen' />
                <SidebarLink closeSide={closeSide} href={route('atur-nama-proyek')} active={route().current('atur-nama-proyek')} label='atur nama proyek' />
                <SidebarLink closeSide={closeSide} href={route('atur-nama-sub-elemen')} active={route().current('atur-nama-sub-elemen')} label='atur nama sub elemen' />
                <SidebarLink closeSide={closeSide} href={route('atur-penilaian-proyek')} active={route().current('atur-penilaian-proyek')} label='atur penilaian proyek' />
                <SidebarLink closeSide={closeSide} href={route('cek-kd')} active={route().current('cek-kd')} label='cek KD/TP' />
                <SidebarLink closeSide={closeSide} href={route('cek-penilaian-kelas')} active={route().current('cek-penilaian-kelas')} label='cek penilaian kelas' />
                <SidebarLink closeSide={closeSide} href={route('cek-penilaian-sikap')} active={route().current('cek-penilaian-sikap')} label='cek penilaian sikap' />
            </div>
        </div>
    )
}

export default SidebarKurikulum