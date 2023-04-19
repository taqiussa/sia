import axios from "axios"

const getAbsensiSiswa = async (tanggal, tahun, jam, kelasId) => {
    try {
        const response = await axios.post(
            route('get-absensi-siswa',
                {
                    tanggal: tanggal,
                    tahun: tahun,
                    jam: jam,
                    kelasId: kelasId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiSiswa