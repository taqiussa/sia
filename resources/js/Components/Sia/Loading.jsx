import React from 'react'
import { LineWave } from "react-loader-spinner";
const Loading = () => {
    return (
        <div className="z-[60] flex justify-center items-center w-full h-full absolute bg-white/80 backdrop-blur">
        <LineWave
            height="150"
            width="150"
            color="#34d399"
            ariaLabel="line-wave"
            wrapperStyle={{}}
            wrapperClass=""
            visible={true}
            firstLineColor=""
            middleLineColor=""
            lastLineColor="" />
    </div>
    )
}

export default Loading