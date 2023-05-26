import Bulan from '@/Components/Sia/Bulan'
import Tahun from '@/Components/Sia/Tahun'
import { namaBulan } from '@/Functions/functions'
import { rupiah } from '@/Functions/functions'
import getSlipGaji from '@/Functions/getSlipGaji'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React from 'react'
import { useEffect } from 'react'
import { trackPromise } from 'react-promise-tracker'

const SlipGaji = ({ initTahun }) => {

    const { data, setData, errors, processing } = useForm({
        tahun: initTahun,
        bulan: moment(new Date()).format('MM'),
        penggajian: []
    })

    async function getData() {
        const response = await getSlipGaji(data.tahun, data.bulan)
        setData({ ...data, penggajian: response.penggajian })
    }
    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    useEffect(() => {

        if (data.tahun && data.bulan) {
            trackPromise(getData())
        }

    }, [data.tahun, data.bulan])
    return (
        <>
            <Head title='Rekap Penggajian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">slip gaji guru dan karyawan bulan {namaBulan(data.bulan)}</div>
            <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-2'>

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Bulan
                    id='bulan'
                    name='bulan'
                    value={data.bulan}
                    message={errors.bulan}
                    handleChange={onHandleChange}
                />

            </div>

            <div className="overflow-x-auto capitalize font-medium text-md text-slate-600 py-5 px-1">
                <table className="w-full lg:w-1/2">
                    <tbody>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-center" colSpan={2}>jenis pendapatan</td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">1. gaji pokok</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.gaji_pokok)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">2. HR jabatan</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.tunjangan_jabatan)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">3. kelebihan jam</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.kelebihan_jam)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">4. pendidikan</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.tunjangan_pendidikan)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">5. subsidi kuliah</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.subsidi_kuliah)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">6. transport ({data.penggajian?.jumlah_hadir ?? 0})</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.tunjangan_transport)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">7. TMT</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.tmt)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200 font-bold text-black">
                            <td className="py-2 px-2">jumlah pendpatan</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.jumlah_pendapatan)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2" colSpan={2}>&nbsp;</td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2 text-center" colSpan={2}>jenis potongan</td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">1. simpanan wajib anggota koperasi</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.wajib)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">2. simpanan pokok</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.pokok)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">3. simpanan hari raya</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.shr)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">4. angsuran BPD/BRI ({data.penggajian?.angsuran_bpd_ke ?? '-'})</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.angsuran_bpd)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">5. angsuran koperasi ({data.penggajian?.angsuran_koperasi_ke ?? '-'})</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.angsuran_koperasi)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">6. bon</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.bon)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">7. DPLK</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.dplk)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                            <td className="py-2 px-2">8. BPJS kesehatan</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.bpjs)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200 font-bold text-black">
                            <td className="py-2 px-2">jumlah potongan</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.jumlah_potongan)}</div>
                                </div>
                            </td>
                        </tr>
                        <tr className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200 font-bold text-black">
                            <td className="py-2 px-2">jumlah terima</td>
                            <td className="py-2 px-2">
                                <div className="flex justify-between">
                                    <div>:</div>
                                    <div className="text-right">{rupiah(data.penggajian?.jumlah_terima)}</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </>
    )
}

SlipGaji.layout = page => <AppLayout children={page} />
export default SlipGaji