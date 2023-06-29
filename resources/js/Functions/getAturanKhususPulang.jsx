import axios from "axios"

const getAturanKhususPulang = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-aturan-khusus-pulang',
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

export default getAturanKhususPulang