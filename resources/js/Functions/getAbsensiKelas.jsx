import axios from "axios"

const getAbsensiKelas = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-absensi-kelas',
                {
                    tanggal: tanggal,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiKelas