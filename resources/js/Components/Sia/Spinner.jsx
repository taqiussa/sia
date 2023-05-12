import React from "react";
import { usePromiseTracker } from "react-promise-tracker";
import { LineWave } from "react-loader-spinner";

export default function Spinner() {
    const { promiseInProgress } = usePromiseTracker({delay:500});
    return (
        promiseInProgress && (
            <div className="z-[60] flex justify-center items-center w-full h-screen absolute bg-white/30 backdrop-blur">
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
    )
}


