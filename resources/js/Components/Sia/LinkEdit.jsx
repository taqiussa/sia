import { Icon } from '@mdi/react';
import { mdiSquareEditOutline } from '@mdi/js';
import { Link } from '@inertiajs/react';

export default function LinkEdit({ href, method = 'get' }) {
    return (
        <Link href={href}
            method={method}
            className='inline-flex items-center   text-slate-600 uppercase tracking-widest hover:text-slate-500 active:text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150'
        >
            <Icon path={mdiSquareEditOutline} size={1} />
        </Link>

    );
}
