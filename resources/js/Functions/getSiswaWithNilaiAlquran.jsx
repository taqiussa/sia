import axios from "axios"

const getSiswaWithNilaiAlquran = async (tahun, kelasId, jenisAlquran) => {
    try {
        const response = await axios.post(
            route('get-siswa-with-nilai-alquran',
                {
                    tahun: tahun,
                    kelasId: kelasId,
                    jenisAlquran: jenisAlquran
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSiswaWithNilaiAlquran