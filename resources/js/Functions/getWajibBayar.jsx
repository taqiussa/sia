import axios from "axios"

const getWajibBayar = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-wajib-bayar',
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

export default getWajibBayar