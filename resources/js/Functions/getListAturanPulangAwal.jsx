import axios from "axios"

const getListAturanPulangAwal = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-list-aturan-pulang-awal',
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

export default getListAturanPulangAwal