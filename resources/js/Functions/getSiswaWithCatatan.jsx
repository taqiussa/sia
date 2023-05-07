import axios from "axios"

const getSiswaWithCatatan = async (tahun, semester, kelasId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-catatan',
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

export default getSiswaWithCatatan