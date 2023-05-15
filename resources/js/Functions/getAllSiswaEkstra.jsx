import axios from "axios"

const getAllSiswaEkstra = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-all-siswa-ekstra',
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

export default getAllSiswaEkstra