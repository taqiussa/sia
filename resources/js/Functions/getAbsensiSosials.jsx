import axios from "axios"

const getAbsensiSosials = async (tahun, role, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-absensi-sosials',
                {
                    tahun,
                    role,
                    jenisKelamin
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAbsensiSosials