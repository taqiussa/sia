import axios from "axios"

const getAllSiswa = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-all-siswa',
                {
                    tahun: tahun
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAllSiswa