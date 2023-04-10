export function hariTanggal(tanggal) {
    return new Date(tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
}

export function tanggal(tanggal) {
    return new Date(tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
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