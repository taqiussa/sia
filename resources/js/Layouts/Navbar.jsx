import { usePage } from '@inertiajs/react'
import React from 'react'

export default function Navbar({ openSide }) {

    const asset = usePage().props;

    return (
        <div className="sticky top-0 px-1 py-2 bg-white/30 backdrop-blur shadow-md shadow-slate-300">

            <div className="flex justify-between">

                <button onClick={() => openSide()} className="flex items-center self-center py-1 pr-2 ml-2 font-bold text-white transition duration-500 transform border-2 border-emerald-800 rounded-xl bg-emerald-600 hover:bg-emerald-500 focus:bg-emerald-500 place-self-start lg:invisible">

                    <svg style={{ width: 24, height: 24 }} viewBox="0 0 24 24">

                        <path fill="currentColor" d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" />

                    </svg>

                    Menu

                </button>

                <div className="flex items-center justify-center text-md lg:text-xl font-extrabold 
                            bg-gradient-to-r bg-clip-text  text-transparent 
                            from-emerald-500 via-lime-500 to-teal-500
                            animate-text pr-3">

                    Sistem Informasi Akademik

                </div>

            </div>

        </div>
    )
}
