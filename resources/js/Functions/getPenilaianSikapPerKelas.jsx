import axios from "axios"

const getPenilaianSikapPerKelas = async (tahun, semester, kelasId) => {
    try {
        const response = await axios.post(
            route('get-penilaian-sikap-per-kelas',
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

export default getPenilaianSikapPerKelas