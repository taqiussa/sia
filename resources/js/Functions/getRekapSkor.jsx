import axios from "axios"

const getRekapSkor = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-rekap-skor',
                {
                    tahun: tahun,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getRekapSkor