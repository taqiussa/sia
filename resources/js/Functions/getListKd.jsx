import axios from "axios"

const getListKd = async (tahun, semester, kategoriNilaiId) => {
    try {
        const response = await axios.post(
            route('get-kd',
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

export default getListKd