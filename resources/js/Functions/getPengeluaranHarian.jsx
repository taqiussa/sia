import axios from "axios"

const getPengeluaranHarian = async (tanggalAwal, tanggalAkhir) => {
    try {
        const response = await axios.post(
            route('get-pengeluaran-harian',
                {
                    tanggalAwal: tanggalAwal,
                    tanggalAkhir: tanggalAkhir
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getPengeluaranHarian