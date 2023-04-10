import { Icon } from '@mdi/react';
import { mdiSquareEditOutline } from '@mdi/js';

export default function Edit({ type = '', className = '', processing, onClick }) {
    return (
        <button
            type={type}
            onClick={onClick}
            className={
                `inline-flex items-center   text-slate-600 uppercase tracking-widest hover:text-slate-500 active:text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150 ${processing && 'opacity-25'
                } ` + className
            }
            disabled={processing}
        >
            <Icon path={mdiSquareEditOutline} size={1} />

        </button>
    );
}
