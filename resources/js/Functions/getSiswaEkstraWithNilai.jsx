import axios from "axios"

const getSiswaEkstraWithNilai = async (tahun, semester, ekstrakurikulerId, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-siswa-ekstra-with-nilai',
                {
                    tahun: tahun,
                    semester: semester,
                    ekstrakurikulerId: ekstrakurikulerId,
                    jenisKelamin: jenisKelamin
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getSiswaEkstraWithNilai