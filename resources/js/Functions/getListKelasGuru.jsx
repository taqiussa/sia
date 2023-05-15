import axios from "axios"

const getListKelasGuru = async (tahun, mataPelajaranId) => {
    try {
        const response = await axios.post(
            route('get-list-kelas-guru',
                {
                    tahun: tahun,
                    mataPelajaranId: mataPelajaranId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListKelasGuru