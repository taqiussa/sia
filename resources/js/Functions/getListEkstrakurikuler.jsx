import axios from "axios"

const getListEkstrakurikuler = async (tahun, semester) => {
    try {
        const response = await axios.post(
            route('get-list-ekstra',
                {
                    tahun: tahun,
                    semester: semester,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListEkstrakurikuler