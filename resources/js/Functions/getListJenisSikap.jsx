import axios from "axios"

const getListJenisSikap = async (tahun, semester, kategoriSikapId, kelasId) => {
    try {
        const response = await axios.post(
            route('get-list-jenis-sikap',
                {
                    tahun: tahun,
                    semester: semester,
                    kategoriSikapId: kategoriSikapId,
                    kelasId: kelasId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJenisSikap