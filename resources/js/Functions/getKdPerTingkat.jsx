import axios from "axios"

const getKdPerTingkat = async (tahun, tingkat) => {
    try {
        const response = await axios.post(
            route('get-kd-per-tingkat',
                {
                    tahun: tahun,
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