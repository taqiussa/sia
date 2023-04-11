import { useState } from 'react';
import Select from 'react-select';

function SearchableSelect({ id, name, options, value, onChange, label, message }) {
    const [selectedOption, setSelectedOption] = useState(value);

    function handleChange(event) {
        setSelectedOption(event);
        onChange(event.value);
    }

    return (


        <div className='flex flex-col text-slate-600 capitalize'>
            <div>
                {label}
            </div>
            <div>
                <Select
                    id={id}
                    name={name}
                    options={options}
                    value={selectedOption}
                    onChange={(e) => handleChange(e)}
                    isSearchable={true}
                    isClearable={true}
                    placeholder={`Pilih ${label}`}
                />
            </div>
            {message ?
                <div className='text-sm text-red-600'>
                    {message}
                </div>
                :
                null
            }
        </div>
    );
}

export default SearchableSelect;
