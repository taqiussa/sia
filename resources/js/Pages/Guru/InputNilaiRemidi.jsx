import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import moment from 'moment'
import React, { useEffect, useState } from 'react'

const InputNilaiRemidi = ({ initTahun, initSemester, listKelas, listMapel, listKategor, listKelas }) => {

    const { data, setData, post, errors, processing } = useForm({
        id: '',
        tanggal: moment(new Date()).format('YYYY-MM-DD'),
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        ki: '',
        materi: '',
        catatan: '',
        arrayInput: []
    })

    return (
        <>
            <Head title='Input Nilai Remidi' />
        </>
    )
}

InputNilaiRemidi.layout = page => <AppLayout children={page} />
export default InputNilaiRemidi