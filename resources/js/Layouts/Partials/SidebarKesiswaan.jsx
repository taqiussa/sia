import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarKesiswaan = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Kesiswaan
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('input-sosial')} active={route().current('input-sosial')} label='input sosial' />
            </div>
        </div>
    )
}

export default SidebarKesiswaan