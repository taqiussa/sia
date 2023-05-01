import SidebarLink from '@/Components/Sia/SidebarLink'
import React from 'react'

const SidebarGuru = ({ closeSide }) => {
    return (
        <div className='py-1'>
            <div className="text-slate-600 font-bold">
                Guru
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('absensi')} active={route().current('absensi')} label='absensi' />
                <SidebarLink closeSide={closeSide} href={route('absensi-ekstrakurikuler')} active={route().current('absensi-ekstrakurikuler')} label='absensi ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('absensi-ujian')} active={route().current('absensi-ujian')} label='absensi ujian' />
                <SidebarLink closeSide={closeSide} href={route('data-siswa-ekstrakurikuler')} active={route().current('data-siswa-ekstrakurikuler')} label='data siswa ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('form-tugas')} active={route().current('form-tugas')} label='form tugas' />
                <SidebarLink closeSide={closeSide} href={route('input-analisis-nilai')} active={route().current('input-analisis-nilai')} label='input analisis nilai' />
                <SidebarLink closeSide={closeSide} href={route('input-deskripsi-ekstrakurikuler')} active={route().current('input-deskripsi-ekstrakurikuler')} label="input KD ekstrakurikuler" />
                <SidebarLink closeSide={closeSide} href={route('input-kd')} active={route().current('input-kd')} label='input KD / TP penilaian' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai')} active={route().current('input-nilai')} label="input nilai" />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-alquran')} active={route().current('input-nilai-alquran')} label="input nilai al qur'an" />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-bilghoib-per-kelas')} active={route().current('input-nilai-bilghoib-per-kelas')} label='input nilai bilghoib per kelas' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-binnadzor-per-kelas')} active={route().current('input-nilai-binnadzor-per-kelas')} label='input nilai binnadzor per kelas' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-ekstrakurikuler')} active={route().current('input-nilai-ekstrakurikuler')} label='input nilai ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-pengayaan')} active={route().current('input-nilai-pengayaan')} label='input nilai pengayaan' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-remidi')} active={route().current('input-nilai-remidi')} label='input nilai remidi' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-sikap')} active={route().current('input-nilai-sikap')} label='input nilai sikap' />
                <SidebarLink closeSide={closeSide} href={route('input-prestasi')} active={route().current('input-prestasi')} label='input prestasi' />
                <SidebarLink closeSide={closeSide} href={route('pendaftaran-siswa-ekstrakurikuler')} active={route().current('pendaftaran-siswa-ekstrakurikuler')} label='pendaftaran siswa ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-ekstrakurikuler')} active={route().current('print-absensi-ekstrakurikuler')} label='print absensi ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-kelas')} active={route().current('print-absensi-kelas')} label='print absensi kelas' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-ujian')} active={route().current('print-absensi-ujian')} label='print absensi ujian' />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-alquran')} active={route().current('print-nilai-alquran')} label="print nilai al qur'an" />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-ekstrakurikuler')} active={route().current('print-nilai-ekstrakurikuler')} label="print nilai ekstrakurikuler" />
                <SidebarLink closeSide={closeSide} href={route('upload-analisis-alquran')} active={route().current('upload-analisis-alquran')} label="upload analisis al qur'an" />
            </div>
        </div>
    )
}

export default SidebarGuru