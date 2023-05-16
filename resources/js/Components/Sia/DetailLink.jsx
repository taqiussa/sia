import { Link } from '@inertiajs/react';

export default function DetailLink({ href, method = 'get', label }) {
    return (
        <Link href={href}
            method={method}
            className='inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase  hover:bg-emerald-500 focus:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150'
        >
            {label}
        </Link>

    );
}
