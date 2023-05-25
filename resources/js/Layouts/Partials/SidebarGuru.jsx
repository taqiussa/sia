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
                <SidebarLink closeSide={closeSide} href={route('biodata-siswa')} active={route().current('biodata-siswa')} label='biodata siswa' />
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
                <SidebarLink closeSide={closeSide} href={route('input-nilai-proyek')} active={route().current('input-nilai-proyek')} label='input nilai projek' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-remidi')} active={route().current('input-nilai-remidi')} label='input nilai remidi' />
                <SidebarLink closeSide={closeSide} href={route('input-nilai-sikap')} active={route().current('input-nilai-sikap')} label='input nilai sikap' />
                <SidebarLink closeSide={closeSide} href={route('input-prestasi')} active={route().current('input-prestasi')} label='input prestasi' />
                <SidebarLink closeSide={closeSide} href={route('input-skor')} active={route().current('input-skor')} label='input skor' />
                <SidebarLink closeSide={closeSide} href={route('input-skor-kelas')} active={route().current('input-skor-kelas')} label='input skor 1 kelas' />
                <SidebarLink closeSide={closeSide} href={route('pendaftaran-siswa-ekstrakurikuler')} active={route().current('pendaftaran-siswa-ekstrakurikuler')} label='pendaftaran siswa ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-ekstrakurikuler')} active={route().current('print-absensi-ekstrakurikuler')} label='print absensi ekstrakurikuler' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-kelas')} active={route().current('print-absensi-kelas')} label='print absensi kelas' />
                <SidebarLink closeSide={closeSide} href={route('print-absensi-ujian')} active={route().current('print-absensi-ujian')} label='print absensi ujian' />
                <SidebarLink closeSide={closeSide} href={route('print-analisis')} active={route().current('print-analisis')} label="print analisis" />
                <SidebarLink closeSide={closeSide} href={route('print-daftar-nilai')} active={route().current('print-daftar-nilai')} label="print daftar nilai" />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-alquran')} active={route().current('print-nilai-alquran')} label="print nilai al qur'an" />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-ekstrakurikuler')} active={route().current('print-nilai-ekstrakurikuler')} label="print nilai ekstrakurikuler" />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-pengayaan')} active={route().current('print-nilai-pengayaan')} label="print nilai pengayaan" />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-remidi')} active={route().current('print-nilai-remidi')} label="print nilai remidi" />
                <SidebarLink closeSide={closeSide} href={route('print-nilai-sikap')} active={route().current('print-nilai-sikap')} label="print nilai sikap" />
                <SidebarLink closeSide={closeSide} href={route('print-pencapaian-kompetensi')} active={route().current('print-pencapaian-kompetensi')} label="print pencapaian kompetensi" />
                <SidebarLink closeSide={closeSide} href={route('saldo-skor')} active={route().current('saldo-skor')} label='saldo skor' />
                <SidebarLink closeSide={closeSide} href={route('upload-analisis-alquran')} active={route().current('upload-analisis-alquran')} label="upload analisis al qur'an" />
                <SidebarLink closeSide={closeSide} href={route('upload-analisis-nilai')} active={route().current('upload-analisis-nilai')} label="upload analisis nilai" />
                <SidebarLink closeSide={closeSide} href={route('upload-nilai')} active={route().current('upload-nilai')} label="upload nilai" />
                <SidebarLink closeSide={closeSide} href={route('upload-nilai-proyek')} active={route().current('upload-nilai-proyek')} label="upload nilai projek" />
                <SidebarLink closeSide={closeSide} href={route('upload-nilai-sikap')} active={route().current('upload-nilai-sikap')} label="upload nilai sikap" />
            </div>
            <div className="text-slate-600 font-bold mt-3">
                Wali Kelas
            </div>
            <div>
                <SidebarLink closeSide={closeSide} href={route('input-alpha')} active={route().current('input-alpha')} label="input alpha" />
                <SidebarLink closeSide={closeSide} href={route('input-catatan-rapor')} active={route().current('input-catatan-rapor')} label="input catatan rapor" />
                <SidebarLink closeSide={closeSide} href={route('input-skor-birrul-walidain')} active={route().current('input-skor-birrul-walidain')} label="input skor birrul walidain" />
                <SidebarLink closeSide={closeSide} href={route('print-ledger-pts')} active={route().current('print-ledger-pts')} label="print ledger PTS" />
                <SidebarLink closeSide={closeSide} href={route('print-ledger-rapor')} active={route().current('print-ledger-rapor')} label="print ledger rapor" />
                <SidebarLink closeSide={closeSide} href={route('print-rapor')} active={route().current('print-rapor')} label="print rapor" />
                <SidebarLink closeSide={closeSide} href={route('print-rapor-proyek')} active={route().current('print-rapor-proyek')} label="print rapor projek" />
                <SidebarLink closeSide={closeSide} href={route('print-rapor-pts')} active={route().current('print-rapor-pts')} label="print rapor PTS" />
                <SidebarLink closeSide={closeSide} href={route('rekap-pembayaran-siswa')} active={route().current('rekap-pembayaran-siswa')} label="rekap pembayaran siswa" />
            </div>
        </div>
    )
}

export default SidebarGuru