import axios from "axios"

const getAdministrasi = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-administrasi',
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

export default getAdministrasi