import axios from "axios"

const getDataNilai = async (tahun, semester) => {
    try {
        const response = await axios.post(
            route('get-data-nilai',
                {
                    tahun: tahun,
                    semester: semester
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getDataNilai