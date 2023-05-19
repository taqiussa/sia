import axios from "axios"

const getAturanPerSubElemen = async (tahun, proyekId, dimensiId, elemenId, subElemenId) => {
    try {
        const response = await axios.post(
            route('get-aturan-per-sub-elemen',
                {
                    tahun: tahun,
                    proyekId: proyekId,
                    dimensiId: dimensiId,
                    elemenId: elemenId,
                    subElemenId: subElemenId,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getAturanPerSubElemen