import axios from "axios"

const getSkorSiswaPerGuru = async (tahun, nis) => {
    try {
        const response = await axios.post(
            route('get-skor-siswa-per-guru',
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

export default getSkorSiswaPerGuru