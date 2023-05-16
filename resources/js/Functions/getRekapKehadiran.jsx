import axios from "axios"

const getRekapKehadiran = async (tanggal, jam) => {
    try {
        const response = await axios.post(
            route('get-rekap-kehadiran',
                {
                    tanggal: tanggal,
                    jam: jam,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapKehadiran