import axios from "axios"

const getRekapAbsensiGuruKaryawan = async (tahun, bulan) => {
    try {
        const response = await axios.post(
            route('get-rekap-absensi-karyawan',
                {
                    tahun: tahun,
                    bulan: bulan
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapAbsensiGuruKaryawan