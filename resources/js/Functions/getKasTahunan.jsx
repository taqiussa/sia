import axios from "axios"

const getKasTahunan = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-kas-tahunan',
                {
                    tahun: tahun
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKasTahunan