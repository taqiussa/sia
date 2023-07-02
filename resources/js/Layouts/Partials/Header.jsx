import React from 'react'

const Header = ({ title }) => {
    return (
        <div className="bg-emerald-200 border-b-2 border-emerald-500 font-bold text-center text-lg text-slate-600 uppercase mb-2">
            {title}
        </div>
    )
}

export default Header