import axios from "axios"

const getPembayaran = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-pembayaran',
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

export default getPembayaran