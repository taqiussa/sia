import axios from "axios"

const getAbsensiHarianKaryawan = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-absensi-harian-karyawan',
                {
                    tanggal: tanggal,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiHarianKaryawan