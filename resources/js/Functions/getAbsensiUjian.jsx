import axios from "axios"

const getAbsensiUjian = async (tanggal, tahun, namaUjian, namaRuang, jam, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-absensi-ujian',
                {
                    tanggal: tanggal,
                    tahun: tahun,
                    namaUjian: namaUjian,
                    namaRuang: namaRuang,
                    jam: jam,
                    jenisKelamin: jenisKelamin
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiUjian