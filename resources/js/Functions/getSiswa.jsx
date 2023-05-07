import axios from "axios"

const getSiswa = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-siswa',
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

export default getSiswa