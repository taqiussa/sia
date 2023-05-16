import axios from "axios"

const getRekapJamKosong = async (tahun, semester, hari, jam) => {
    try {
        const response = await axios.post(
            route('get-rekap-jam-kosong',
                {
                    tahun: tahun,
                    semester: semester,
                    hari: hari,
                    jam: jam,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapJamKosong