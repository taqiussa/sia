import axios from "axios"

const getAllSiswaWithBiodata = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-all-siswa-with-biodata',
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

export default getAllSiswaWithBiodata