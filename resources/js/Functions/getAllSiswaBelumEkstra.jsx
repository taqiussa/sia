import axios from "axios"

const getAllSiswaBelumEkstra = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-all-siswa-belum-ekstra',
                {
                    tahun: tahun
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAllSiswaBelumEkstra