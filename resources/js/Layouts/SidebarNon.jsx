import React from 'react';
import SidebarLink from '@/Components/Sia/SidebarLink';
import { Icon } from '@mdi/react';
import { mdiAccountCircleOutline } from '@mdi/js';
export default function SidebarNon({ open, closeSide }) {
    return (
        <div>
            <div className={`lg:w-[310px] w-[250px] h-full py-5 px-0 fixed overflow-x-hidden overflow-y-scroll myscroll top-0 left-0 z-50 shadow-md transition duration-300 lg:translate-x-0 backdrop-blur bg-white/80  ${open ? 'translate-x-0 ease-in' : 'lg:-translate-x-[310px] -translate-x-[250px] ease-out'}`}>
                <div className="px-4">
                    <button onClick={() => closeSide()} className="absolute p-1 text-white transition duration-300 transform border-2 rounded-full shadow-md bg-emerald-600 right-5 top-5 border-emerald-700 hover:bg-emerald-500 focus:bg-emerald-500 lg:invisible">
                        <svg style={{ width: 24, height: 24 }} viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20 6.91L17.09 4L12 9.09L6.91 4L4 6.91L9.09 12L4 17.09L6.91 20L12 14.91L17.09 20L20 17.09L14.91 12L20 6.91Z" />
                        </svg>
                    </button>
                    <div className='flex flex-col items-center text-emerald-500'>

                        <Icon path={mdiAccountCircleOutline} size={4} />

                        <h1 className="block py-3 text-lg font-bold text-emerald-700">ABSENSI GURU DAN KARYAWAN</h1>
                    </div>

                    <SidebarLink closeSide={closeSide} href={route('absensi-ketenagaan')} active={route().current('absensi-ketenagaan')} label='absensi karyawan' />

                </div>
            </div >
        </div>
    )
}
