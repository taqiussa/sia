import React from "react";
import { LineWave } from "react-loader-spinner";

export default function SpinnerNonPromise() {
    return (
        <div className="z-[60] flex justify-center items-center w-[80%] h-screen absolute bg-white/80 backdrop-blur">
            <div>
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
                <div className="font-bold text-emerald-500">
                    Loading...
                </div>
            </div>
        </div>
    )
}


