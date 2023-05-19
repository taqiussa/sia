import axios from "axios"

const getListAturanProyek = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-list-aturan-proyek',
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

export default getListAturanProyek