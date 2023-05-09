import axios from "axios"

const getGuruIzin = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-guru-izin',
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

export default getGuruIzin