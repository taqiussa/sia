import axios from "axios"

const getPemasukanHarian = async (tanggalAwal, tanggalAkhir) => {
    try {
        const response = await axios.post(
            route('get-pemasukan-harian',
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

export default getPemasukanHarian