import { Icon } from '@mdi/react';
import { mdiTrashCanOutline } from '@mdi/js';

export default function Hapus({ type = '', className = '', processing, onClick }) {
    return (
        <button
            type={type}
            onClick={onClick}
            className={
                `inline-flex items-center   text-red-600 uppercase tracking-widest hover:text-red-500 active:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ${processing && 'opacity-25'
                } ` + className
            }
            disabled={processing}
        >
            <Icon path={mdiTrashCanOutline} size={1} />

        </button>
    );
}
