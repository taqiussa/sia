import axios from "axios"

const getListJenisAlquranWithNilaiSiswa = async (kategoriAlquran, nis) => {
    try {
        const response = await axios.post(
            route('get-list-jenis-alquran-with-nilai-siswa',
                {
                    kategoriAlquran: kategoriAlquran,
                    nis: nis
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListJenisAlquranWithNilaiSiswa