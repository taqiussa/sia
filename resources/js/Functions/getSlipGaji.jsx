import axios from "axios"

const getSlipGaji = async (tahun, bulan) => {
    try {
        const response = await axios.post(
            route('get-slip-gaji',
                {
                    tahun: tahun,
                    bulan: bulan
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSlipGaji