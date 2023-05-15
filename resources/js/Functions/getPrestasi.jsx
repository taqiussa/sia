import axios from "axios"

const getPrestasi = async (tahun, semester) => {
    try {
        const response = await axios.post(
            route('get-prestasi',
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

export default getPrestasi