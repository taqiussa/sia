import axios from "axios"

const getSiswaWithSkor = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-skor',
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

export default getSiswaWithSkor