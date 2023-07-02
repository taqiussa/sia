import axios from "axios"

const getRekapTransportPerKaryawan = async (tahun, bulan, userId) => {
    try {
        const response = await axios.post(
            route('get-rekap-transport-per-karyawan',
                {
                    tahun,
                    bulan,
                    userId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapTransportPerKaryawan