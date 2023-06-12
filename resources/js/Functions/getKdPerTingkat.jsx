import axios from "axios"

const getKdPerTingkat = async (tahun, semester, tingkat) => {
    try {
        const response = await axios.post(
            route('get-kd-per-tingkat',
                {
                    tahun: tahun,
                    semester: semester,
                    tingkat: tingkat
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKdPerTingkat