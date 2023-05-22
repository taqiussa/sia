import PrimaryButton from '@/Components/PrimaryButton'
import InputText from '@/Components/Sia/InputText'
import JenisPenilaian from '@/Components/Sia/JenisPenilaian'
import KategoriNilai from '@/Components/Sia/KategoriNilai'
import Kelas from '@/Components/Sia/Kelas'
import MataPelajaran from '@/Components/Sia/MataPelajaran'
import Semester from '@/Components/Sia/Semester'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import getListJenis from '@/Functions/getListJenis'
import getListKategori from '@/Functions/getListKategori'
import getListKelasGuru from '@/Functions/getListKelasGuru'
import getSiswaWithAnalisisNilai from '@/Functions/getSiswaWithAnalisisNilai'
import AppLayout from '@/Layouts/AppLayout'
import { Head, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { trackPromise } from 'react-promise-tracker'
import { toast } from 'react-toastify'

const InputAnalisisNilai = ({ initTahun, initSemester, listMapel }) => {

    const { data, setData, errors, post, processing, delete: destroy } = useForm({
        tahun: initTahun,
        semester: initSemester,
        mataPelajaranId: '',
        kelasId: '',
        kategoriNilaiId: '',
        jenisPenilaianId: '',
        listKelas: [],
        listKategori: [],
        listJenis: [],
        arrayInput: []
    })

    const [listSiswa, setListSiswa] = useState([])
    const [count, setCount] = useState(0)

    async function getDataSiswa() {
        const response = await getSiswaWithAnalisisNilai(data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId)
        setListSiswa(response.listSiswa)
    }

    async function getDataKelas() {
        const response = await getListKelasGuru(data.tahun, data.mataPelajaranId)
        setData({
            ...data,
            listKelas: response.listKelas
        })
    }

    async function getDataKategori() {
        const response = await getListKategori(data.tahun, data.kelasId)
        setData({
            ...data,
            listKategori: response.listKategori
        })
    }

    async function getDataJenis() {
        const response = await getListJenis(data.tahun, data.semester, data.kategoriNilaiId, data.kelasId)
        setData({
            ...data,
            listJenis: response.listJenis
        })
    }

    const submit = (e) => {
        e.preventDefault()
        post(
            route('input-analisis-nilai.simpan'),
            {
                onSuccess: () => {
                    toast.success('Berhasil Simpan Penilaian')
                    setData({ ...data })
                    getDataSiswa()
                },
            }
        )
    }

    const handleDelete = (id) => {
        Sweet
            .fire({
                title: 'Anda yakin menghapus?',
                text: "Hapus Nilai!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            })
            .then((result) => {
                if (result.isConfirmed)
                    destroy(
                        route('input-analisis-nilai.hapus', { id: id }),
                        {
                            onSuccess: () => {
                                toast.success('Berhasil Hapus Data Penilaian')
                                setData({ ...data })
                                getDataSiswa()
                            }
                        }
                    )
            })
    }

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleDynamicKeterampilan = (e, index, nis, kelasId, id, no1, no2, no3, no4, idPenilaian, nilai, name) => {
        const no = parseInt(e.target.name.slice(2)) // extract the number from the name attribute (e.g. 'no1' => 1)
        const newList = [...listSiswa]
        const analisis_penilaian = { id }
        for (let i = 1; i <= 4; i++) {
            const prop = `no_${i}`
            analisis_penilaian[prop] = (i === no) ? e.target.value : (i === 1 ? no1 : i === 2 ? no2 : i === 3 ? no3 : no4)
        }
        newList.splice(index, 1, {
            nis,
            kelas_id: kelasId,
            analisis_penilaian,
            penilaian: {
                id: idPenilaian,
                nilai: nilai
            },
            user: { name },
        })
        setListSiswa(newList)
        setCount(count + 1)
    }

    const handleDynamicPengetahuan = (e, index, nis, kelasId, id, no1, no2, no3, no4, no5, no6, no7, no8, no9, no10, idPenilaian, nilai, name) => {
        const no = parseInt(e.target.name.slice(2)) // extract the number from the name attribute (e.g. 'no1' => 1)
        const newList = [...listSiswa]
        const analisis_penilaian = { id }
        for (let i = 1; i <= 10; i++) {
            const prop = `no_${i}`
            analisis_penilaian[prop] = (i === no) ? e.target.value : (i === 1 ? no1 : i === 2 ? no2 : i === 3 ? no3 : i === 4 ? no4 : i === 5 ? no5 : i === 6 ? no6 : i === 7 ? no7 : i === 8 ? no8 : i === 9 ? no9 : no10)
        }
        newList.splice(index, 1, {
            nis,
            kelas_id: kelasId,
            analisis_penilaian,
            penilaian: {
                id: idPenilaian,
                nilai: nilai
            },
            user: { name },
        })
        setListSiswa(newList)
        setCount(count + 1)
    }

    useEffect(() => {

        if (
            data.tahun
            && data.semester
            && data.mataPelajaranId
            && data.kelasId
            && data.kategoriNilaiId
            && data.jenisPenilaianId
        ) {
            trackPromise(
                getDataSiswa()
            )
        } else {
            setListSiswa([])
        }

    }, [data.tahun, data.semester, data.mataPelajaranId, data.kelasId, data.kategoriNilaiId, data.jenisPenilaianId])


    useEffect(() => {

        if (data.tahun && data.mataPelajaranId)
            trackPromise(getDataKelas())
    }, [data.tahun, data.mataPelajaranId])

    useEffect(() => {

        if (data.kelasId)
            trackPromise(getDataKategori())
    }, [data.kelasId])

    useEffect(() => {

        if (data.kategoriNilaiId) {
            setData('jenisPenilaianId', '')
            trackPromise(getDataJenis())
        }
    }, [data.semester, data.kategoriNilaiId])


    useEffect(() => {

        setData({
            ...data,
            arrayInput: [...listSiswa],
        })
    }, [count])

    return (
        <>
            <Head title='Input Analisis Nilai' />
            <div className="border-b-2 border-emerald-500 bg-emerald-200 font-bold text-lg text-center text-slate-600 uppercase mb-2">input analisis nilai</div>
            <div className="grid grid-cols-2 gap-2 lg:grid lg:grid-cols-6 lg:gap-2 lg:space-y-0 mb-2">

                <Tahun
                    id='tahun'
                    name='tahun'
                    value={data.tahun}
                    message={errors.tahun}
                    handleChange={onHandleChange}
                />

                <Semester
                    id='semester'
                    name='semester'
                    value={data.semester}
                    message={errors.semester}
                    handleChange={onHandleChange}
                />

                <MataPelajaran
                    id='mataPelajaranId'
                    name='mataPelajaranId'
                    value={data.mataPelajaranId}
                    message={errors.mataPelajaranId}
                    handleChange={onHandleChange}
                    listMapel={listMapel}
                />

                <Kelas
                    id='kelasId'
                    name='kelasId'
                    value={data.kelasId}
                    message={errors.kelasId}
                    handleChange={onHandleChange}
                    listKelas={data.listKelas}
                />

                <KategoriNilai
                    id='kategoriNilaiId'
                    name='kategoriNilaiId'
                    value={data.kategoriNilaiId}
                    message={errors.kategoriNilaiId}
                    handleChange={onHandleChange}
                    listKategori={data.listKategori}
                />

                <JenisPenilaian
                    id='jenisPenilaianId'
                    name='jenisPenilaianId'
                    value={data.jenisPenilaianId}
                    message={errors.jenisPenilaianId}
                    handleChange={onHandleChange}
                    listJenis={data.listJenis}
                />

            </div>

            <div className="overflow-x-auto pt-3">
                <table className="w-full text-sm text-slate-600">
                    <thead className="text-sm text-slate-600 ">
                        <tr className=" capitalize whitespace-nowrap bg-gray-50">
                            <th className=" px-2 py-2">no</th>
                            <th className=" px-2 py-2 text-left pl-2 sticky left-0 bg-inherit">nama</th>
                            {data.kategoriNilaiId == 3 || data.kategoriNilaiId == 6 ?
                                <>
                                    <th className=" px-2 py-2">no 1</th>
                                    <th className=" px-2 py-2">no 2</th>
                                    <th className=" px-2 py-2">no 3</th>
                                    <th className=" px-2 py-2">no 4</th>
                                    <th className=" px-2 py-2">no 5</th>
                                    <th className=" px-2 py-2">no 6</th>
                                    <th className=" px-2 py-2">no 7</th>
                                    <th className=" px-2 py-2">no 8</th>
                                    <th className=" px-2 py-2">no 9</th>
                                    <th className=" px-2 py-2">no 10</th>
                                    <th className=" px-2 py-2">nilai</th>
                                </>
                                :
                                <>
                                    <th className=" px-2 py-2">aspek 1</th>
                                    <th className=" px-2 py-2">aspek 2</th>
                                    <th className=" px-2 py-2">aspek 3</th>
                                    <th className=" px-2 py-2">aspek 4</th>
                                </>
                            }
                        </tr>
                    </thead>
                    <tbody>
                        {listSiswa && listSiswa.map((siswa, index) => (
                            <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                                <td className="py-2 px-2 font-medium text-slate-600 text-center">
                                    {index + 1}
                                </td>
                                <td className="py-2 px-2 font-medium text-slate-600 sticky left-0 bg-inherit">
                                    {siswa.user.name}
                                </td>
                                {
                                    data.kategoriNilaiId == 3 || data.kategoriNilaiId == 6 ?
                                        <>
                                            {Array.from({ length: 10 }, (_, i) => i + 1).map((no) => (
                                                <td className="py-2 px-2 font-medium text-slate-600" key={no}>
                                                    <div className="flex flex-col">

                                                        <InputText
                                                            key={no}
                                                            id={`no${no}`}
                                                            name={`no${no}`}
                                                            label={`no ${no}`}
                                                            value={siswa.analisis_penilaian?.[`no_${no}`] || ''}
                                                            className='w-auto max-w-[60px]'
                                                            handleChange={(e) => handleDynamicPengetahuan(e, index, siswa.nis, siswa.kelas_id, siswa.analisis_penilaian?.id,
                                                                siswa.analisis_penilaian?.no_1 || '',
                                                                siswa.analisis_penilaian?.no_2 || '',
                                                                siswa.analisis_penilaian?.no_3 || '',
                                                                siswa.analisis_penilaian?.no_4 || '',
                                                                siswa.analisis_penilaian?.no_5 || '',
                                                                siswa.analisis_penilaian?.no_6 || '',
                                                                siswa.analisis_penilaian?.no_7 || '',
                                                                siswa.analisis_penilaian?.no_8 || '',
                                                                siswa.analisis_penilaian?.no_9 || '',
                                                                siswa.analisis_penilaian?.no_10 || '',
                                                                siswa.penilaian.id,
                                                                siswa.penilaian.nilai,
                                                                siswa.user.name
                                                            )}
                                                            handleBlur={(e) => onHandleBlurPengetahuan(e, siswa.nis, siswa.analisis_penilaian?.id,
                                                                siswa.analisis_penilaian?.no_1 || '',
                                                                siswa.analisis_penilaian?.no_2 || '',
                                                                siswa.analisis_penilaian?.no_3 || '',
                                                                siswa.analisis_penilaian?.no_4 || '',
                                                                siswa.analisis_penilaian?.no_5 || '',
                                                                siswa.analisis_penilaian?.no_6 || '',
                                                                siswa.analisis_penilaian?.no_7 || '',
                                                                siswa.analisis_penilaian?.no_8 || '',
                                                                siswa.analisis_penilaian?.no_9 || '',
                                                                siswa.analisis_penilaian?.no_10 || '',
                                                                siswa.penilaian.id
                                                            )}
                                                        />
                                                    </div>
                                                </td>
                                            ))}
                                        </>
                                        :
                                        <>
                                            {Array.from({ length: 4 }, (_, i) => i + 1).map((no) => (
                                                <td className="py-2 px-2 font-medium text-slate-600" key={no}>
                                                    <div className="flex flex-col">

                                                        <InputText
                                                            key={no}
                                                            id={`no${no}`}
                                                            name={`no${no}`}
                                                            label={`no ${no}`}
                                                            value={siswa.analisis_penilaian?.[`no_${no}`] || ''}
                                                            className='w-auto max-w-[60px]'
                                                            handleChange={(e) => handleDynamicKeterampilan(e, index, siswa.nis, siswa.kelas_id, siswa.analisis_penilaian?.id,
                                                                siswa.analisis_penilaian?.no_1 || '',
                                                                siswa.analisis_penilaian?.no_2 || '',
                                                                siswa.analisis_penilaian?.no_3 || '',
                                                                siswa.analisis_penilaian?.no_4 || '',
                                                                siswa.penilaian.id,
                                                                siswa.penilaian.nilai,
                                                                siswa.user.name
                                                            )}
                                                            handleBlur={(e) => onHandleBlurKeterampilan(e, siswa.nis, siswa.analisis_penilaian?.id,
                                                                siswa.analisis_penilaian?.no_1 || '',
                                                                siswa.analisis_penilaian?.no_2 || '',
                                                                siswa.analisis_penilaian?.no_3 || '',
                                                                siswa.analisis_penilaian?.no_4 || '',
                                                                siswa.penilaian.id
                                                            )}
                                                        />
                                                    </div>
                                                </td>
                                            ))}
                                        </>
                                }

                                <td className="py-2 px-2 font-medium text-slate-600">
                                    {siswa.penilaian?.nilai}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className="flex justify-end pt-5 pr-2">
                <PrimaryButton children='simpan' onClick={submit} disabled={processing} />
            </div>
        </>

    )
}

InputAnalisisNilai.layout = page => <AppLayout children={page} />
export default InputAnalisisNilai