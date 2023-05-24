import axios from "axios"

const getListJenisPerTingkat = async (tahun, semester, kategoriNilaiId, tingkat) => {
    try {
        const response = await axios.post(
            route('get-list-jenis-per-tingkat',
                {
                    tahun: tahun,
                    semester: semester,
                    kategoriNilaiId: kategoriNilaiId,
                    tingkat: tingkat
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJenisPerTingkat