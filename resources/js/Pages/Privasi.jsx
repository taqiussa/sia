import { Head } from '@inertiajs/react'
import React from 'react'
import logo from '../../../public/images/logoalfa2.png'
import moment from 'moment'

const Privasi = () => {
    return (
        <>
            <Head title='Kebijakan dan Privasi' />
            <div className="px-2 py-2 container-fluid flex items-center justify-center">
                <main className='mb-20 max-w-xl bg-white space-y-7'>
                    <div className='flex flex-col justify-center items-center space-y-7'>
                        <img src={logo} className='w-28' alt='logo' />
                        <div className="text-slate-600 text-xl lg:text-2xl font-bold lg:tracking-widest text-center">
                            SMP AL MUSYAFFA
                        </div>
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Terima kasih atas kunjungan Anda di siakad.smpalmusyaffa.com. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat Anda menggunakan situs web kami. Dengan menggunakan situs web kami, Anda menyetujui praktik yang dijelaskan dalam kebijakan privasi ini.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Pengumpulan Informasi Pribadi
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Kami mengumpulkan informasi pribadi yang Anda berikan secara sukarela, seperti nama, alamat email, dan informasi kontak lainnya. Kami juga dapat mengumpulkan informasi teknis, seperti alamat IP Anda, jenis perangkat keras dan perangkat lunak yang Anda gunakan, dan informasi tentang bagaimana Anda menggunakan situs web kami.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Penggunaan Informasi Pribadi
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Kami menggunakan informasi pribadi Anda untuk menyediakan layanan yang diminta, seperti mengirimkan newsletter atau informasi tentang acara dan produk kami. Kami juga dapat menggunakan informasi pribadi Anda untuk mengirim pesan pemasaran tentang produk dan layanan kami, kecuali jika Anda telah memilih untuk tidak menerima pesan semacam itu. Kami tidak akan menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Keamanan Informasi Pribadi
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Kami mengambil tindakan yang tepat untuk melindungi informasi pribadi Anda dari akses yang tidak sah, penggunaan, atau pengungkapan. Kami menggunakan teknologi keamanan yang tepat untuk melindungi informasi pribadi Anda.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Penggunaan Cookies
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Kami menggunakan cookies untuk mengumpulkan informasi tentang bagaimana Anda menggunakan situs web kami dan untuk meningkatkan pengalaman pengguna Anda. Cookie adalah file kecil yang disimpan oleh browser web Anda di hard drive perangkat Anda. Anda dapat mengatur browser web Anda untuk menolak cookie atau memberi tahu Anda saat cookie dikirim. Namun, jika Anda menolak cookie, Anda mungkin tidak dapat menggunakan beberapa bagian dari situs web kami.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Tautan ke Situs Web Pihak Ketiga
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Situs web kami dapat berisi tautan ke situs web pihak ketiga. Kami tidak bertanggung jawab atas praktik privasi situs web pihak ketiga tersebut.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Perubahan Kebijakan Privasi
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Kami dapat mengubah kebijakan privasi kami dari waktu ke waktu. Perubahan tersebut akan diberitahukan melalui situs web kami.
                    </div>
                    <div className="text-xl text-slate-600 font-bold">
                        Hubungi Kami
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Jika Anda memiliki pertanyaan tentang kebijakan privasi kami, silakan hubungi kami di email: kendalikoding@gmail.com.
                    </div>
                    <div className="text-md text-slate-600 text-justify">
                        Terima kasih telah membaca kebijakan privasi kami. Semoga informasi ini bermanfaat bagi Anda.
                    </div>
                </main>
            </div>
            <footer className='py-1 px-2 text-slate-600 bottom-0 fixed bg-white/30 backdrop-blur w-full'>
                &copy; SMP Al Musyaffa 2022 - {moment(new Date()).format('YYYY')} | Developed By Kendali Koding
            </footer>
        </>
    )
}

export default Privasi