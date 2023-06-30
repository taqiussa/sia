import axios from "axios"

const getListAturanPulangSpesial = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-list-aturan-pulang-spesial',
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

export default getListAturanPulangSpesial