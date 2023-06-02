import AppLayout from '@/Layouts/AppLayout'
import { Head } from '@inertiajs/react'
import React from 'react'

const AturPulangAwal = () => {
    return (
        <>
            <Head title='Atur Pulang Awal' />
        </>
        )
}

AturPulangAwal.layout = page => <AppLayout children={page} />
export default AturPulangAwal