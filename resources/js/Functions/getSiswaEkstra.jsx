import axios from "axios"

const getSiswaEkstra = async (tahun, ekstrakurikulerId, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-siswa-ekstra',
                {
                    tahun: tahun,
                    ekstrakurikulerId: ekstrakurikulerId,
                    jenisKelamin: jenisKelamin
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSiswaEkstra