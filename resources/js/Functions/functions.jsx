export function arrayGunabayar() {
    const bulan = [
        { id: 1, nama: 'SPP Bulan Juli' },
        { id: 2, nama: 'SPP Bulan Agustus' },
        { id: 3, nama: 'SPP Bulan September' },
        { id: 4, nama: 'SPP Bulan Oktober' },
        { id: 5, nama: 'SPP Bulan November' },
        { id: 6, nama: 'SPP Bulan Desember' },
        { id: 7, nama: 'SPP Bulan Januari' },
        { id: 8, nama: 'SPP Bulan Februari' },
        { id: 9, nama: 'SPP Bulan Maret' },
        { id: 10, nama: 'SPP Bulan April' },
        { id: 11, nama: 'SPP Bulan Mei' },
        { id: 12, nama: 'SPP Bulan Juni' }
    ]
    return bulan
}

export function hariTanggal(tanggal) {
    return new Date(tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
}

export function maskRupiah(angka) {
    // Remove all non-numeric characters
    const numericValue = angka.replace(/\D/g, '')
    // Add a thousands separator
    const formattedValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    // Add the 'Rp.' prefix and return the formatted value
    return `Rp. ${formattedValue}`
}

export function rupiah(angka) {
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    return formatter.format(angka);
}

export function tanggal(tanggal) {
    return new Date(tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
}

