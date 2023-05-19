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
                <SidebarLink closeSide={closeSide} href={route('atur-nama-proyek')} active={route().current('atur-nama-proyek')} label='atur nama proyek' />
            </div>
        </div>
    )
}

export default SidebarKurikulum