import axios from "axios"

const getSiswaWithAlpha = async (tahun, semester, kelasId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-alpha',
                {
                    tahun: tahun,
                    semester: semester,
                    kelasId: kelasId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSiswaWithAlpha