import axios from "axios"

const getAbsensiSosial = async (tanggal, role, jenisKelamin) => {
    try {
        const response = await axios.post(
            route('get-absensi-sosial',
                {
                    tanggal,
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

export default getAbsensiSosial