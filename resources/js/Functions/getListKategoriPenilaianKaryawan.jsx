import axios from "axios"

const getListKategoriPenilaianKaryawan = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-list-kategori-penilaian-karyawan',
                {
                    tahun
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListKategoriPenilaianKaryawan