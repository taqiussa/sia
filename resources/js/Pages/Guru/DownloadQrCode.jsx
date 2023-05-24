import AppLayout from '@/Layouts/AppLayout';
import React, { useState } from 'react';
import QRCode from 'qrcode';

const DownloadQrCode = () => {
    const [qrCodeValues, setQRCodeValues] = useState([]);

    const downloadQRCode = async (data, width, height) => {
        try {
            const qrCodeUrl = await QRCode.toDataURL(data.value, { width, height });
            const downloadLink = document.createElement('a');
            downloadLink.href = qrCodeUrl;
            downloadLink.download = `${data.name}.png`; // Access the name property of the data object
            downloadLink.click();
        } catch (error) {
            console.error('Error generating QR code:', error);
        }
    };

    const databaseData = [
        { id: 1, name: 'John', value: 'Data 1' },
        { id: 2, name: 'Jane', value: 'Data 2' },
        { id: 3, name: 'Bob', value: 'Data 3' },
    ];

    return (
        <>
            {databaseData.map((data) => (
                <div key={data.id}>
                    <button onClick={() => downloadQRCode(data, 400, 400)}>Download QR Code {data.id}</button>
                </div>
            ))}
        </>
    );
};

DownloadQrCode.layout = (page) => <AppLayout children={page} />;
export default DownloadQrCode;
