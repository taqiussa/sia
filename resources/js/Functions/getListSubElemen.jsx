import axios from "axios"

const getListSubElemen = async (elemenId) => {
    try {
        const response = await axios.post(
            route('get-list-sub-elemen',
                {
                    elemenId: elemenId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListSubElemen