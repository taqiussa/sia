import axios from "axios"

const getListKategori = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-list-kategori',
                {
                    tahun: tahun,
                    kelasId: kelasId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListKategori