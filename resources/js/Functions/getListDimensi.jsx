import axios from "axios"

const getListDimensi = async (tahun, proyekId) => {
    try {
        const response = await axios.post(
            route('get-list-dimensi',
                {
                    tahun: tahun,
                    proyekId: proyekId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListDimensi