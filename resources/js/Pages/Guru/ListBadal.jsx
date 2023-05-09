import { hariTanggal } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'

const ListBadal = ({ listBadalan }) => {
    return (
        <>
            <Head title='List Badal' />
            <div className="font-bold text-lg text-slate-600 mb-2">
                *Jadwal Badal : {hariTanggal(moment(new Date()).format('YYYY-MM-DD'))}*
            </div>
            <div className="overflow-x-auto">
                <table className="w-full">
                    <tbody>
                        {listBadalan && listBadalan.map((badal, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600">
                                    *{index + 1}. Badal : {badal.badal?.name}* <br />
                                    Jam : {badal.jam} <br />
                                    Kelas : {badal.kelas?.nama} <br />
                                    Mapel : {badal.mapel?.nama} <br />
                                    Tugas : {badal.tugas} <br />
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>

    )
}

ListBadal.layout = page => <AppLayout children={page} />
export default ListBadal