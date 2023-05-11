import BentukBimbingan from '@/Components/Sia/BentukBimbingan'
import Hapus from '@/Components/Sia/Hapus'
import InputText from '@/Components/Sia/InputText'
import Paginator from '@/Components/Sia/Paginator'
import Sweet from '@/Components/Sia/Sweet'
import Tahun from '@/Components/Sia/Tahun'
import { hariTanggal } from '@/Functions/functions'
import AppLayout from '@/Layouts/AppLayout'
import { Head, router, useForm } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { toast } from 'react-toastify'

const RekapBimbingan = ({ initTahun, listBimbingan, filters }) => {

  const { data, setData, errors, delete: destroy } = useForm({
    tahun: initTahun,
    bentukBimbingan: 'Individu',
    search: filters.search ?? ''
  })

  const onHandleChange = (e) => {
    setData(e.target.name, e.target.value)
  }

  const handleDelete = (id) => {
    Sweet.fire({
      title: 'Anda yakin menghapus?',
      text: "Hapus Data Bimbingan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    })
      .then((result) => {
        if (result.isConfirmed) {
          destroy(route('rekap-bimbingan.hapus',
            {
              id: id,
              tahun: data.tahun,
              bentukBimbingan: data.bentukBimbingan,
              search: data.search
            }),
            {
              onSuccess: () => {
                toast.success('Berhasil Hapus Data Bimbingan')
                setData({
                  tahun: data.tahun,
                  search: data.search,
                  bentukBimbingan: data.bentukBimbingan
                })

                getDataRekapBimbingan()

              }
            })
        }
      })
  }

  useEffect(() => {

    if (data.tahun && data.bentukBimbingan)
      router.reload(
        {
          only: ['listBimbingan'],
          data: {
            tahun: data.tahun,
            bentukBimbingan: data.bentukBimbingan
          },
          preserveState: true,
          replace: true
        },
      )

  }, [data.tahun, data.bentukBimbingan])

  useEffect(() => {
    const timerId = setTimeout(() => {
      router.reload(
        {
          only: ['listBimbingan'],
          data: {
            tahun: data.tahun,
            bentukBimbingan: data.bentukBimbingan,
            search: data.search
          },
          preserveState: true,
          replace: true
        },
      )
    }, 1000)

    return () => {
      clearTimeout(timerId)
    }
  }, [data.search])
  return (
    <>
      <Head title='Data pembayaran Siswa' />
      <div className="font-bold text-lg text-center text-slate-600 uppercase border-b-2 border-emerald-500 mb-3 bg-emerald-200">rekap bimbingan</div>
      <div className='lg:grid lg:grid-cols-4 lg:gap-2 lg:space-y-0 space-y-3'>

        <Tahun
          id='tahun'
          name='tahun'
          label='tahun'
          value={data.tahun}
          message={errors.tahun}
          handleChange={onHandleChange}
        />

        <BentukBimbingan
          id='bentukBimbingan'
          name='bentukBimbingan'
          value={data.bentukBimbingan}
          message={errors.bentukBimbingan}
          handleChange={onHandleChange}
        />

        <InputText
          id='search'
          name='search'
          value={data.search}
          message={errors.search}
          label='search'
          handleChange={onHandleChange}
        />
      </div>
      <div className="overflow-x-auto">
        <table className="w-full text-sm text-slate-600">
          <thead className="text-sm text-slate-600 bg-gray-50">
            <tr>
              <th scope='col' className="py-3 px-2">
                No
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Tanggal
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Nama
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Kelas
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Permasalahan
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Tindak Lanjut
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Guru
              </th>
              <th scope='col' className="py-3 px-2 text-left">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            {listBimbingan &&
              listBimbingan.data.map((list, index) => (
                <tr key={index} className="bg-white border-b hover:bg-slate-300 odd:bg-slate-200">
                  <td className="py-2 px-2 font-medium text-slate-600 text-center">
                    {index + 1 + ((listBimbingan.current_page - 1) * listBimbingan.per_page)}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600">
                    {hariTanggal(list.tanggal)}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600">
                    {list.user?.name}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600">
                    {list.kelas?.nama}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600">
                    {list.permasalahan}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600">
                    {list.tindak_lanjut}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600">
                    {list.bk?.user?.name}
                  </td>
                  <td className="py-2 px-2 font-medium text-slate-600 inline-flex space-x-3">
                    <Hapus
                      onClick={() => handleDelete(list.id)}
                    />
                  </td>
                </tr>
              ))}
          </tbody>
        </table>
      </div>
      <Paginator lists={listBimbingan} />
    </>
  )
}

RekapBimbingan.layout = page => <AppLayout children={page} />
export default RekapBimbingan