import axios from "axios"

const getAturanPerProyek = async (tahun, proyekId) => {
    try {
        const response = await axios.post(
            route('get-aturan-per-proyek',
                {
                    tahun: tahun,
                    proyekId: proyekId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAturanPerProyek