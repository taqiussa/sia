import axios from "axios"

const getSiswaWithNilaiSikap = async (tahun, semester, mataPelajaranId, kelasId, kategoriSikapId, jenisSikapId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-nilai-sikap',
                {
                    tahun: tahun,
                    semester: semester,
                    mataPelajaranId: mataPelajaranId,
                    kelasId: kelasId,
                    kategoriSikapId: kategoriSikapId,
                    jenisSikapId: jenisSikapId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSiswaWithNilaiSikap