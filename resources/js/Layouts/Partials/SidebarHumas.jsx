import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarHumas = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Humas
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('input-sosial')} active={route().current('input-sosial')} label='input sosial' />
                <SidebarLink closeSide={closeSide} href={route('rekap-sosial')} active={route().current('rekap-sosial')} label='rekap sosial' />
                <SidebarLink closeSide={closeSide} href={route('total-sosial')} active={route().current('total-sosial')} label='total sosial' />
            </div>
        </div>
    )
}

export default SidebarHumas