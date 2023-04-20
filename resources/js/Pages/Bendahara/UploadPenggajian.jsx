import PrimaryButton from '@/Components/PrimaryButton'
import FileUpload from '@/Components/Sia/FileUpload'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React from 'react'
import { toast } from 'react-toastify'

const UploadPenggajian = () => {
    const { data, setData, post, errors, processing } = useForm({
        fileUpload: ''
    })

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.type === 'file' ? e.target.files[0] : e.target.value)
    }

    const submit = (e) => {

        e.preventDefault()
        post(route('upload-penggajian.upload'), {
            onSuccess: () => {
                toast.success('Berhasil Upload Penggajian')
                setData({ fileUpload: '' })
            }
        })

    }
    return (
        <>
            <Head title='Upload Penggajian' />
            <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">upload penggajian</div>
            <form onSubmit={submit} className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3'>
                <FileUpload
                    id='fileUpload'
                    name='fileUpload'
                    message={errors.fileUpload}
                    handleChange={onHandleChange}
                />
                <div className="flex items-end">
                    <PrimaryButton onClick={submit} disabled={processing}>upload</PrimaryButton>
                </div>
            </form>
        </>
    )
}

UploadPenggajian.layout = page => <AppLayout children={page} />
export default UploadPenggajian