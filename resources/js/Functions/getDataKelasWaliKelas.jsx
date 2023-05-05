import axios from "axios"

const getDataKelasWaliKelas = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-kelas-wali-kelas',
                {
                    tahun: tahun,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getDataKelasWaliKelas