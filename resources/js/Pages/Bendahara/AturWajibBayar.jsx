import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Tahun from '@/Components/Sia/Tahun'
import Tingkat from '@/Components/Sia/Tingkat'
import InputText from '@/Components/Sia/InputText'
import { maskRupiah } from '@/Functions/functions'
import getWajibBayar from '@/Functions/getWajibBayar'

const AturWajibBayar = ({ initTahun }) => {

    const { data, setData, post, errors, proccessing, delete: destroy } = useForm({
        tahun: initTahun,
        tingkat: '',
        jumlah: ''
    })
    
    const [listWajibBayar, setListWajibBayar] = useState([])

    async function getDataWajibBayar() {
        const response = await getWajibBayar(data.tahun)

        setListWajibBayar(response.listWajibBayar)
    }


    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value)
    }

    const handleRupiah = (event) => {
        const value = event.target.value
        setData('jumlah', maskRupiah(value))
    }

    return (
        <>
            <Head title='Atur Wajib Bayar' />
            <div className='grid grid-cols-3 gap-2'>
                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Tingkat
                    id='tingkat'
                    name='tingkat'
                    value={data.tingkat}
                    message={errors.tingkat}
                    handleChange={onHandleChange}
                />

                <InputText
                    id="jumlah"
                    label="Jumlah"
                    name="jumlah"
                    value={data.jumlah}
                    message={errors.jumlah}
                    isFocused={true}
                    handleChange={handleRupiah}
                />
            </div>
        </>
    )

}

AturWajibBayar.layout = page => <AppLayout children={page} />
export default AturWajibBayar
