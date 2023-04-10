import React from 'react';
import SidebarLink from '@/Components/Sia/SidebarLink';
import { Icon } from '@mdi/react';
import { mdiAccountCircleOutline } from '@mdi/js';
import SidebarAdmin from './Partials/SidebarAdmin';
import SidebarBendahara from './Partials/SidebarBendahara';
import SidebarKonseling from './Partials/SidebarKonseling';
import SidebarKurikulum from './Partials/SidebarKurikulum';
import SidebarGuru from './Partials/SidebarGuru';
import SidebarTataUsaha from './Partials/SidebarTataUsaha';
import SidebarKaryawan from './Partials/SidebarKaryawan';
import SidebarKesiswaan from './Partials/SidebarKesiswaan';
import SidebarSiswa from './Partials/SidebarSiswa';
import SidebarKepalaSekolah from './Partials/SidebarKepalaSekolah';
export default function Sidebar({ open, closeSide, auth }) {
    return (
        <div>
            <div className={`w-[264px] h-full py-5 px-0 fixed overflow-x-hidden overflow-y-scroll myscroll top-0 left-0 z-50 shadow-md transition duration-500 lg:translate-x-0 backdrop-blur bg-white/50  ${open ? 'translate-x-0 ease-in' : '-translate-x-[264px] ease-out'}`}>
                <div className="px-4">
                    <button onClick={() => closeSide()} className="absolute p-1 text-white transition duration-500 transform border-2 rounded-full shadow-md bg-emerald-600 right-5 top-5 border-emerald-700 hover:bg-emerald-500 focus:bg-emerald-500 lg:invisible">
                        <svg style={{ width: 24, height: 24 }} viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20 6.91L17.09 4L12 9.09L6.91 4L4 6.91L9.09 12L4 17.09L6.91 20L12 14.91L17.09 20L20 17.09L14.91 12L20 6.91Z" />
                        </svg>
                    </button>
                    <div className='flex flex-col items-center text-emerald-500'>
                        {auth.user.foto ?
                            <img src={`/images/${auth.user.foto}`} className='w-28 h-28 rounded-full border-2 border-emerald-500 object-cover object-top' alt='foto' />
                            :
                            <Icon path={mdiAccountCircleOutline} size={4} />

                        }
                        <h1 className="block py-3 text-lg font-bold text-emerald-700">{auth.user.name}</h1>
                    </div>
                    {!auth.roles.includes('Siswa') ?
                        <>

                            <SidebarLink closeSide={closeSide} href={route('profile-pengguna')} active={route().current('profile-pengguna')} label='profile pengguna' />

                            {auth.roles.includes('Admin') &&
                                <SidebarAdmin closeSide={closeSide} />
                            }

                            {auth.roles.includes('Bendahara') &&
                                <SidebarBendahara closeSide={closeSide} />
                            }

                            {auth.roles.includes('Guru') &&
                                <SidebarGuru closeSide={closeSide} />
                            }

                            {auth.roles.includes('Karyawan') &&
                                <SidebarKaryawan closeSide={closeSide} />
                            }

                            {auth.roles.includes('Kepala Sekolah') &&
                                <SidebarKepalaSekolah closeSide={closeSide} />
                            }

                            {auth.roles.includes('Kesiswaan') &&
                                <SidebarKesiswaan closeSide={closeSide} />
                            }

                            {auth.roles.includes('Konseling') &&
                                <SidebarKonseling closeSide={closeSide} />
                            }

                            {auth.roles.includes('Kurikulum') &&
                                <SidebarKurikulum closeSide={closeSide} />
                            }

                            {auth.roles.includes('Tata Usaha') &&
                                <SidebarTataUsaha closeSide={closeSide} />
                            }


                        </>

                        :
                        <>
                            {auth.roles.includes('Siswa') &&
                                <SidebarSiswa closeSide={closeSide} />
                            }
                        </>
                    }

                    <div className='mt-5'>

                        <SidebarLink href={route('logout')} method="post" as="button" label='log out' />

                    </div>
                </div>
            </div >
        </div>
    )
}
