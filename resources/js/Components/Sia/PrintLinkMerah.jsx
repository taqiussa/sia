import { Icon } from '@mdi/react';
import { mdiPrinter } from '@mdi/js';


export default function PrintLinkMerah({ href, label, processing, className }) {
    return (
        <div className="items-center whitespace-nowrap">
            <a
                href={href}
                target="_blank" rel="noopener noreferrer"
                className={
                    `inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ${processing && 'opacity-25'
                    } ` + className
                }
            >
                <Icon path={mdiPrinter} size={1} className="mr-2" />
                {label}
            </a>
        </div>
    );
}
