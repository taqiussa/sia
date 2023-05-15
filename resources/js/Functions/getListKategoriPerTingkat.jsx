import axios from "axios"

const getListKategoriPerTingkat = async (tahun, tingkat) => {
    try {
        const response = await axios.post(
            route('get-list-kategori-per-tingkat',
                {
                    tahun: tahun,
                    tingkat: tingkat
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListKategoriPerTingkat