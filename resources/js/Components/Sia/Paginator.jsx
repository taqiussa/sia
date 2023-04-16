import React from 'react'
import { Link } from '@inertiajs/react'

const Paginator = ({ lists }) => {
    return (
        <div className='my-5 overflow-x-auto flex items-center space-x-1 text-slate-600'>
            {lists.links && lists.links.map((link, index) => (
                link.url ?
                    <Link key={index} href={link.url} className={`${link.active ? 'font-bold bg-emerald-300' : null} focus:shadow-outline transition-colors duration-150 border-emerald-500 hover:bg-emerald-300 rounded-md py-1 px-2 border`} preserveState={true} preserveScroll={true}>
                        {
                            link.label == 'pagination.previous' ? 'previous' :
                                link.label == 'pagination.next' ? 'next' :
                                    link.label
                        }
                    </Link>
                    :
                    <span key={index} className='focus:shadow-outline transition-colors duration-150 border-emerald-500  rounded-md py-1 px-2 border text-gray-400 cursor-not-allowed'>
                        {
                            link.label == 'pagination.previous' ? 'previous' :
                                link.label == 'pagination.next' ? 'next' :
                                    link.label
                        }
                    </span>
            ))}
        </div>
    )
}

export default Paginator