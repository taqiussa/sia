import axios from "axios"

const getPembayaranSiswa = async (tahun, nis) => {
    try {
        const response = await axios.post(
            route('get-pembayaran-siswa',
                {
                    tahun: tahun,
                    nis: nis
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getPembayaranSiswa