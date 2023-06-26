import axios from "axios"

const getListJenisPenilaianKaryawan = async (tahun, kategoriNilaiId) => {
    try {
        const response = await axios.post(
            route('get-list-jenis-penilaian-karyawan',
                {
                    tahun, kategoriNilaiId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJenisPenilaianKaryawan