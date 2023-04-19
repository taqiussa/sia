import axios from "axios"

const getInfoAbsensi = async (tanggal, kelasId) => {
    try {
        const response = await axios.post(
            route('get-info-absensi',
                {
                    tanggal: tanggal,
                    kelasId: kelasId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getInfoAbsensi