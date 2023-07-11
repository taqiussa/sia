import PrimaryButton from '@/Components/PrimaryButton'
import FileUpload from '@/Components/Sia/FileUpload'
import AppLayout from '@/Layouts/AppLayout'
import Header from '@/Layouts/Partials/Header'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'
import { toast } from 'react-toastify'

const UploadSiswa = () => {

    const { data, setData, post, errors, processing } = useForm({
        fileUploadKelasTujuh: '',
        fileUpload: '',
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.files[0])
    }

    const submitKelasTujuh = (e) => {
        e.preventDefault()

        post(route('upload-siswa-baru'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Upload')
                }
            })
    }

    const submit = (e) => {
        e.preventDefault()

        post(route('upload-siswa-lama'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Upload')
                }
            })
    }

    return (
        <>
            <Head title='Upload Siswa' />
            <Header title='upload siswa' />
            <div className="flex flex-col space-y-20 pt-10">
                <div className="lg:inline-flex lg:space-y-0 space-y-2">
                    <FileUpload
                        id='fileUploadKelasTujuh'
                        name='fileUploadKelasTujuh'
                        label='Upload Siswa Kelas 7'
                        message={errors.fileUploadKelasTujuh}
                        handleChange={onHandleChange}
                    />
                    <div className='lg:flex lg:items-end'>
                        <PrimaryButton onClick={submitKelasTujuh} children='upload' disabled={processing} />
                    </div>
                </div>
                <div className="lg:inline-flex lg:space-y-0 space-y-2">
                    <FileUpload
                        id='fileUpload'
                        name='fileUpload'
                        label='Upload Siswa Kelas 8 dan 9'
                        message={errors.fileUpload}
                        handleChange={onHandleChange}
                    />
                    <div className='lg:flex lg:items-end'>
                        <PrimaryButton onClick={submit} children='upload' disabled={processing} />
                    </div>
                </div>
            </div>
        </>
    )
}

UploadSiswa.layout = page => <AppLayout children={page} />
export default UploadSiswa