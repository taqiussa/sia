import axios from "axios"

const getPenggajian = async (tahun, bulan) => {
    try {
        const response = await axios.post(
            route('get-penggajian',
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

export default getPenggajian