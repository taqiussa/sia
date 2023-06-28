import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarTataUsaha = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className='text-slate-600 font-bold'>
                Tata Usaha
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('download-qr-code')} active={route().current('download-qr-code')} label='download qr code' />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-alquran-tata-usaha')} active={route().current('print-nilai-alquran-tata-usaha')} label="print nilai al qur'an" />
            </div>
        </div>
    )
}

export default SidebarTataUsaha