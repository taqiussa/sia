import axios from "axios"

const getPenilaianPerKelas = async (tahun, semester, kelasId) => {
    try {
        const response = await axios.post(
            route('get-penilaian-per-kelas',
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

export default getPenilaianPerKelas