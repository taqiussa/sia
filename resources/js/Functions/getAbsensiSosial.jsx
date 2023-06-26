import axios from "axios"

const getAbsensiSosial = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-absensi-sosial',
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

export default getAbsensiSosial