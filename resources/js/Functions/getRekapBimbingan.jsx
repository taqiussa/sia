import axios from "axios"

const getRekapBimbingan = async (tahun, bentukBimbingan) => {
    try {
        const response = await axios.post(
            route('get-rekap-bimbingan',
                {
                    tahun: tahun,
                    bentukBimbingan: bentukBimbingan,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapBimbingan