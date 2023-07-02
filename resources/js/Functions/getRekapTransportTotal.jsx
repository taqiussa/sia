import axios from "axios"

const getRekapTransportTotal = async (bulan, tahun) => {
    try {
        const response = await axios.post(
            route('get-rekap-transport-total',
                {
                    tahun,
                    bulan
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapTransportTotal