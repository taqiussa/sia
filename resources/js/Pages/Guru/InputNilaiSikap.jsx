import AppLayout from '@/Layouts/AppLayout'
import { useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'

const InputNilaiSikap = ({ initTahun, initSemester, listKelas, listMapel, listKategori, listJenis }) => {

    const { data, setData, post, errors, processing } = useForm({
        tahun: initTahun,
        semester: initSemester,
        kelasId: '',
        mataPelajaranId: '',
        kategoriSikapId: '',
        jenisSikapId: '',
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)
    const [message, setMessage] = useState([])

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamic = (e, index, id, nis, namaSiswa, kelasId, tindakLanjut) => {

        const newList = [...listSiswa]
        newList.splice(index, 1 {
            nis: nis,
            kelas_id: kelasId,
            user: {
                name: namaSiswa
            },
            penilaian_sikap: {
                id: id,
                nilai: e.target.value,
                tindak_lanjut: tindakLanjut
            }
        })

        setMessage([])

        setListSiswa(newList)
        
        setCount(count + 1)
    }

    const onHandleBlur = (e, id, nis, kelasId) => {
        
    }

    return (
        <>

        </>
    )
}

InputNilaiSikap.layout = page => <AppLayout children={page} />
export default InputNilaiSikap