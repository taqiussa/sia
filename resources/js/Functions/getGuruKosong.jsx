import axios from "axios"

const getGuruKosong = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-guru-kosong',
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

export default getGuruKosong