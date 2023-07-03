import axios from "axios"

const getAbsensiIbadah = async (tahun, bulan, minggu, jenisIbadah, kategori, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-absensi-ibadah',
                {
                    tahun, bulan, minggu, jenisIbadah, kategori, jenisKelamin
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiIbadah