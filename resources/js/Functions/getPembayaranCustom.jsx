import axios from "axios"

const getPembayaranCustom = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-pembayaran-custom',
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

export default getPembayaranCustom