import axios from "axios"

const getPengeluaran = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-pengeluaran',
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

export default getPengeluaran