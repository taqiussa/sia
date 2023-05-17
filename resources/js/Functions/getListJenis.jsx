import axios from "axios"

const getListJenis = async (tahun, semester, kategoriNilaiId, kelasId) => {
    try {
        const response = await axios.post(
            route('get-list-jenis',
                {
                    tahun: tahun,
                    semester: semester,
                    kategoriNilaiId: kategoriNilaiId,
                    kelasId: kelasId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJenis