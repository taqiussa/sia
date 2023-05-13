import axios from "axios"

const getKasBulanan = async (tahun, bulan) => {
    try {
        const response = await axios.post(
            route('get-kas-bulanan',
                {
                    tahun: tahun,
                    bulan: bulan,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKasBulanan