import axios from "axios"

const getDataSkor = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-data-skor',
                {
                    tahun: tahun,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getDataSkor