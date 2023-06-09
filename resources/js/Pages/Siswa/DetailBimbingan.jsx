import DetailLink from '@/Components/Sia/DetailLink'
import AppLayout from '@/Layouts/AppLayout'
import { Head, usePage } from '@inertiajs/react'
import React from 'react'

const DetailBimbingan = ({ bimbingan }) => {

    const { auth } = usePage().props

    return (
        <>
            <Head title='Detail Bimbingan' />
            <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">
                detail bimbingan dan konseling
            </div>
            <div className='mb-5'>
                {!auth.roles.includes('Siswa') ?
                    <DetailLink href={route('rekap-bimbingan')} label={
                        <div className='inline-flex items-center'>
                            <svg style={{ width: 24, height: 24 }} viewBox="0 0 24 24">

                                <path fill="currentColor" d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" />

                            </svg>
                            <div>
                                Kembali
                            </div>
                        </div>
                    } />
                    :
                    <DetailLink href={route('data-bimbingan')} label={
                        <div className='inline-flex items-center'>
                            <svg style={{ width: 24, height: 24 }} viewBox="0 0 24 24">

                                <path fill="currentColor" d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" />

                            </svg>
                            <div>
                                Kembali
                            </div>
                        </div>
                    } />
                }
            </div>
            <div className="lg:flex lg:justify-center">
                <div className="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                    {
                        bimbingan.foto &&
                        <img className="md:object-fit object-contain px-1 w-full rounded-t-lg h-96 md:rounded-none md:rounded-l-lg" src={`/storage/${bimbingan.foto}`} alt='foto' />
                    }
                    <div className="flex flex-col justify-between p-4 leading-normal">
                        <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{bimbingan.user?.name}</h5>
                        <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">Permasalahan : {bimbingan.permasalahan}</p>
                        <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">Penyelesaian : {bimbingan.penyelesaian}</p>
                        <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">Tindak Lanjut : {bimbingan.tindak_lanjut}</p>
                    </div>
                </div>
            </div>
            {
                bimbingan.foto_dokumen &&
                <>
                    <div className="font-bold text-slate-600 text-lg mt-5">Foto Dokumen :</div>
                    <div className="flex justify-center my-2 bg-white border border-gray-200 rounded-lg shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <img className="md:object-fit object-contain px-1 w-full rounded-t-lg h-96 md:rounded-none md:rounded-l-lg" src={`/storage/${bimbingan.foto_dokumen}`} alt='foto dokumen' />
                    </div>
                </>
            }
        </>
    )
}

DetailBimbingan.layout = page => <AppLayout children={page} />
export default DetailBimbingan