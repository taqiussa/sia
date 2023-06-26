import axios from "axios"

const getListSosial = async (tahun) => {
    try {
        const response = await axios.post(
            route('get-list-sosial',
                {
                    tahun
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListSosial