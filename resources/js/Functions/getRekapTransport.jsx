import axios from "axios"

const getRekapTransport = async (tahun, bulan) => {
    try {
        const response = await axios.post(
            route('get-rekap-transport',
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

export default getRekapTransport