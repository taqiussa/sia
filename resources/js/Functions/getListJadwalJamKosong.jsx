import axios from "axios"

const getListJadwalJamKosong = async (tahun, userId) => {
    try {
        const response = await axios.post(
            route('get-list-jadwal-kosong',
                {
                    tahun: tahun,
                    userId: userId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJadwalJamKosong