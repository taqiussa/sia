import axios from "axios"

const getSiswaWithNilaiProyek = async (tahun, kelasId, proyekId, dimensiId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-nilai-proyek',
                {
                    tahun: tahun,
                    kelasId: kelasId,
                    proyekId: proyekId,
                    dimensiId: dimensiId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSiswaWithNilaiProyek