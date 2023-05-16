import { Link } from '@inertiajs/react';
import { mdiNewspaperVariantOutline } from '@mdi/js';
import { Icon } from '@mdi/react';

export default function DetailIcon({ href, method = 'get', label }) {
    return (
        <Link href={href}
            method={method}
            className={
                `inline-flex items-center   text-slate-600 uppercase tracking-widest hover:text-slate-500 active:text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150  `
            }
        >
            <Icon path={mdiNewspaperVariantOutline} size={1} />
        </Link>

    );
}
