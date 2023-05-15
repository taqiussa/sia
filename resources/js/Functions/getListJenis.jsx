import axios from "axios"

const getListJenis = async (tahun, semester, kategoriNilaiId) => {
    try {
        const response = await axios.post(
            route('get-list-jenis',
                {
                    tahun: tahun,
                    semester: semester,
                    kategoriNilaiId: kategoriNilaiId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJenis