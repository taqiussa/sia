import axios from "axios"

const getSkorKelas = async (tanggal, kelasId) => {
    try {
        const response = await axios.post(
            route('get-skor-kelas',
                {
                    tanggal: tanggal,
                    kelasId: kelasId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSkorKelas