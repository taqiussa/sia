import Sweet from '@/Components/Sia/Sweet'
import AppLayout from '@/Layouts/AppLayout'
import { useForm } from '@inertiajs/react'
import React from 'react'
import { toast } from 'react-toastify'

const JadwalJamKosong = ({ initTahun, initSemester, listUser }) => {

    const { data, setData, post, errors, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        userId: '',
        hari: '',
        jam: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {

        e.preventDefault()

        post(route('jadwal-jam-kosong.simpan'),

            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Jam Kosong')
                    setData({
                        tahun: data.tahun,
                        semester: data.semester,
                        userId: data.userId,
                        hari: data.hari,
                        jam: data.jam
                    })
                }
            }
        )
    }

    const handleDelete = (id) => {

        Sweet
            .fire({
                title: 'Menghapus Jadwal Jam Kosong',
                text: 'Anda yakin menghapus ?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then(result => {
                if (result.isConfirmed)
                    destroy(
                        route('jadwal-jam-kosong.hapus', {
                            id: id
                        }
                        ),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Jadwal Jam Kosong')
                                setData({
                                    tahun: data.tahun,
                                    semester: data.semester,
                                    userId: data.userId,
                                    hari: data.hari,
                                    jam: data.jam
                                })
                            }
                        }
                    )
            })

    }

    return (
        <>

        </>
    )
}

JadwalJamKosong.layout = page => <AppLayout children={page} />
export default JadwalJamKosong