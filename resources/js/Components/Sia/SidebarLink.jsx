import { Link } from "@inertiajs/react";

export default function SidebarLink({ href, active, label, method, as, closeSide }) {
    function handleClick() {
        if (closeSide) {
            closeSide();
        }
    }
    return (
        <Link
            href={href}
            className={
                active
                    ? 'border-l pl-3 relative flex items-center cursor-pointer  font-semibold hover:text-emerald-700 text-emerald-500 text-md  hover:border-emerald-500 border-emerald-400 capitalize'
                    : 'border-l border-slate-300 pl-3 relative flex items-center cursor-pointer  font-semibold hover:text-emerald-500 text-md  text-slate-500 hover:border-emerald-400 capitalize'
            }
            method={method}
            as={as}
            onClick={handleClick}
            preserveScroll={true}
        >
            {label}
        </Link >
    );
}