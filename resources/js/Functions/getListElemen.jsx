import axios from "axios"

const getListElemen = async (dimensiId) => {
    try {
        const response = await axios.post(
            route('get-list-elemen',
                {
                    dimensiId: dimensiId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListElemen