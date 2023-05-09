import axios from "axios"

const getGuruSudahBadal = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-guru-sudah-badal',
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

export default getGuruSudahBadal