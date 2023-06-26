import axios from "axios"

const getKaryawanWithNilai = async (tahun, kategoriNilaiId, jenisPenilaianId) => {
    try {
        const response = await axios.post(
            route('get-karyawan-with-nilai',
                {
                    tahun,
                    kategoriNilaiId,
                    jenisPenilaianId
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getKaryawanWithNilai