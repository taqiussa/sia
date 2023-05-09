import axios from "axios"

const getPermintaanBadal = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-permintaan-badal',
                {
                    tanggal: tanggal
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getPermintaanBadal