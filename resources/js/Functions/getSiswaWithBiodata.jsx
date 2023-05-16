import axios from "axios"

const getSiswaWithBiodata = async (tahun, kelasId) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-biodata',
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

export default getSiswaWithBiodata