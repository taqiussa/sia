import { Icon } from '@mdi/react';
import { mdiPrinter } from '@mdi/js';


export default function PrintIcon({ href, label, processing, className }) {
    return (
        <a
            href={href}
            target="_blank" rel="noopener noreferrer"
            className={
                `inline-flex items-center   text-emerald-600 uppercase tracking-widest hover:text-emerald-500 active:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 ${processing && 'opacity-25'
                } ` + className
            }
        >
            <Icon path={mdiPrinter} size={1} />
        </a>
    );
}
