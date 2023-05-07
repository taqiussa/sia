import axios from "axios"

const getSiswaWithSkorWaliKelas = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-skor-wali-kelas',
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

export default getSiswaWithSkorWaliKelas