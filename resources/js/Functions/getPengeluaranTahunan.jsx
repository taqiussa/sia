import axios from "axios"

const getPengeluaranTahunan = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-pengeluaran-tahunan',
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

export default getPengeluaranTahunan