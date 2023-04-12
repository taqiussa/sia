export default function Checkbox({ className = '', refs, ...props }) {
    return (
        <input
            {...props}
            type="checkbox"
            ref={refs}
            className={
                'rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 ' +
                className
            }
        />
    );
}
