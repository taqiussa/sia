import axios from "axios"

const getListTugas = async (tanggal) => {
    try {
        const response = await axios.post(
            route('get-list-tugas',
                {
                    tanggal: tanggal,
                })
        )
        return response.data;
    }
    catch (error) {
        console.log(error)
    }
}

export default getListTugas