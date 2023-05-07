import axios from "axios"

const getSkorSiswa = async (tanggal, nis) => {
    try {
        const response = await axios.post(
            route('get-skor-siswa',
                {
                    tanggal: tanggal,
                    nis: nis
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSkorSiswa